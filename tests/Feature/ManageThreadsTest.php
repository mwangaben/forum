<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ManageThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test **/
    public function a_guest_can_not_create_a_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());
    }

    /** @test **/
    public function it_a_guest_can_not_see_create_page()
    {
        $this->withExceptionHandling()
            ->get('threads/create')
            ->assertRedirect('/login');
    }

    /** @test **/
    public function an_authenticated_user_can_create_a_forum_thread()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title);
    }

    /** @test **/
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');

    }

    /** @test **/
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test **/
    public function a_threads_requires_a_valid_channel()
    {
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test **/
    public function unauthorised_user_can_not_delete_a_thread()
    {
    	$this->withExceptionHandling();

        $thread = create(Thread::class);
        $this->delete($thread->path())
            ->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);

    }

    /** @test **/
    public function authorised_users_can_delete_threads()
    {
        $this->signIn();
        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply  = create(Reply::class, ['thread_id' => $thread->id]);

        $this->json('DELETE', $thread->path());
        $this->assertDatabaseMissing('threads', [
            'thread_title' => $thread->title,
            'thread_body'  => $thread->body,
        ]);

        $this->assertDatabaseMissing('replies', [
            'body' => $reply->body,
        ]);
    }

    protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make(Thread::class, $overrides);

        return $this->post('/threads', $thread->toArray());

    }

}
