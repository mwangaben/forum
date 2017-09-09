<?php

namespace Tests\Feature;

use App\Activity;
use App\Thread;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test **/
    public function it_records_activity_when_thread_is_created()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->assertDatabaseHas('activities', [
            'type'         => 'thread_created',
            'user_id'      => auth()->id(),
            'subject_id'   => $thread->id,
            'subject_type' => get_class($thread),
        ]);

        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test **/
    public function it_records_activity_when_reply_is_left()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->assertDatabaseHas('activities', [
            'type'         => 'reply_created',
            'user_id'      => auth()->id(),
            'subject_id'   => $reply->id,
            'subject_type' => get_class($reply),
        ]);
        $this->assertEquals(2, Activity::count());
    }

    /** @test **/
    public function it_fetches_activity_a_feed_for_any_user()
    {
        $this->signIn();
        $thread = create(Thread::class, ['user_id' => auth()->id()], 2);

        auth()->user()->activity()->first()->update([
            'created_at' => Carbon::now()->subWeek(),
        ]);

        $feed = Activity::feed(auth()->user(), 50);

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
