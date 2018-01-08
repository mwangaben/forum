<?php

namespace Tests\Unit;

use App\User;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ThreadWasUpdated;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    /** @test **/
    public function setUp()
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

    public function a_thread_has_replies()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $this->thread->replies
        );
    }

    /** @test **/
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test **/
    public function a_thread_has_a__reply()
    {
        $this->thread->addReply([
            'body' => 'Foo',
            'user_id' => 1
            ]);
        $this->assertCount(1, $this->thread->replies);
    }

    /**	@test **/
    public function a_thread_notifies_all_registered_subscribers_when_the_reply_is_left()
    {
        Notification::fake();

        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
            'body' => 'FooBar',
            'user_id' => 1,
        ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /** @test **/
    public function a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

    /** @test **/
    public function it_a_thread_can_make_a_string_path()
    {
        $this->assertEquals('/threads/' . $this->thread->channel->slug . '/' . $this->thread->id, $this->thread->path());
    }

    /**	@test **/
    public function a_thread_can_be_subscribed_to()
    {
        //  Given we have a thread

        $thread = create(Thread::class);

        // When the user subscribed to the thread

        $thread->subscribe($userId = 1);

        // We should be a able to fetch allthread that a user is subscribed to

        $this->assertEquals(
            1,
             $thread->subscriptions()->where('user_id', $userId)->count()
        );
    }

    /**	@test **/
    public function a_thread_can_be_unsubscribed_from()
    {
        // give we have a thread
        $thread = create(Thread::class);

        // And a user who subscribed to the thread

        $thread->subscribe($userId = 1);

        // When we unsubscribe from the thread

        $thread->unsubscribe($userId = 1);

        // We should be no longer be subscribed into the that thread

        $this->assertEquals(
            0,
           $thread->subscriptions()->where('user_id', $userId)->count()
        );
    }

    /**	@test **/
    public function it_knows_if_the_user_is_subscribed_to()
    {
        // give we have a thread
        $thread = create(Thread::class);

        // And a user who subscribed to the thread
        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }
}
