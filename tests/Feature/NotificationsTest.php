<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Thread;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /**	@test **/
    public function a_notification_is_prepared_when_a_subscribed_thread_received_a_new_reply_is_left_that_is_not_by_the_current_user()
    {
        $thread = create(Thread::class)->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        // Reply left by the me
        $thread->addReply(
            [
                'user_id' => auth()->id(),
                'body' => 'reply is left'
            ]
        );

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        // Reply left by someone else

        $thread->addReply(
            [
                'user_id' => create('App\User')->id,
                'body' => 'reply is left'
                ]
            );

        // we should prepare a notification for the subscribed user

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /**	@test **/
    public function users_can_fetch_their_unread_notification()
    {
        create(DatabaseNotification::class);

        $response = $this->getJson('profiles/' . auth()->user()->name . '/notifications')->json();

        $this->assertCount(1, $response);
    }

    /**	@test **/
    public function a_user_can_mark_a_notification_as_read()
    {
        create(DatabaseNotification::class);

        tap(auth()->user(), function ($user) {
            $this->assertCount(1, $user->unreadNotifications);

            $this->delete("profiles/{$user->name}/notifications/{$user->unreadNotifications->first()->id}");

            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }
}
