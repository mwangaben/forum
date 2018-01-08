<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Thread;

class ThreadSubscriptionTest extends TestCase
{
    use DatabaseMigrations;

    /**	@test **/
    public function a_user_can_subscribe_to_a_thread()
    {
        $this->signIn();

        // Given we have a thread

        $thread = create(Thread::class);

        // And a user subscribe to that thread

        $this->post($thread->path() . '/subscribe')->assertStatus(200);

        // When a reply is left

        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    /**	@test **/
    public function a_user_can_unsubscribe_to_the_thread()
    {
        $this->signIn();

        //Given we havea thread

        $thread = create(Thread::class);

        //and a subscribed user

        $thread->subscribe();

        //when the user is unsubscribe

        $this->delete($thread->path() . '/subscribe')->assertStatus(200);

        $this->assertCount(0, $thread->subscriptions);
    }
}
