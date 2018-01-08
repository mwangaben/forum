<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test **/
    public function an_authenticated_user_can_participate_in_a_forum()
    {
        // Given i have an authenticated user;
        $this->signIn();

        // And i have a Thread
        $thread = create(Thread::class);

        // When i post a reply on a thread
        $reply = make(Reply::class);
        $this->post($thread->path() . '/replies', $reply->toArray());

        // Then I should see the reply being saved i the database
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);

        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /** @test **/
    public function unauthenticated_user_can_not_add_replies_on_threads()
    {
        $this->expectException('Exception');
        $thread = factory(Reply::class)->create();

        $reply = factory(Reply::class)->make();
        $this->post($thread->path() . '/replies', $reply->toArray());
    }

    /** @test **/
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create(Thread::class);

        $reply = make(Reply::class, ['body' => null]);
        $this->post($thread->path() . '/replies', $reply->toArray())
             ->assertSessionHasErrors('body');
    }

    /** @test
    * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
    **/
    public function anauthorized_user_can_not_comment_on_the_deleted_thread()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->json('DELETE', $thread->path());

        $this->assertDatabaseMissing('threads', [
              'title' => $thread->title,
              'body' => $thread->body
            ]);

        $reply = make('App\Reply', ['user_id' => auth()->id()]);
        $this->post($thread->path() . '/replies', $reply->toArray());

        // $this->assertRedirect('thread');
          // $this->asse
    }
}
