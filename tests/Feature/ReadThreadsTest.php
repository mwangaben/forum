<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;
    protected $thread;
    public function setUp()
    {
        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }
    /** @test **/
    public function a_user_can_browse_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test **/
    public function a_user_can_browse_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test **/
    public function it_a_user_can_read_replies_that_are_associated_with_the_thread()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test **/
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(Channel::class);

        $threadWithChannel     = create(Thread::class, ['channel_id' => $channel->id]);
        $threadwithoutAChannel = create(Thread::class);

        $this->get('threads/' . $channel->slug)
            ->assertSee($threadWithChannel->title)
            ->assertDontSee($threadwithoutAChannel->title);
    }

    /** @test **/
    public function a_user_can_filter_threads_according_to_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'Mwangaben']));

        $threadByMwangaBen    = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByMwangaBen = create('App\Thread');

        $this->get('threads?by=Mwangaben')
            ->assertSee($threadByMwangaBen->title)
            ->assertDontSee($threadNotByMwangaBen->title);
    }

    /** @test **/
    public function a_user_can_sort_threads_according_to_popularity()
    {
        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReply = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
