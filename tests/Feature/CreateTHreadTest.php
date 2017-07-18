<?php

namespace Tests\Feature;

use App\User;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateTHreadTest extends TestCase
{
    use DatabaseMigrations;
    
      /** @test **/ 
	function a_guest_can_not_create_a_thread()
	{
		$this->expectException('Illuminate\Auth\AuthenticationException');
		$thread = make('App\Thread');

		$this->post('/threads', $thread->toArray());
	}

	  /** @test **/ 
	function it_a_guest_can_not_see_create_page()
	{
      $this->withExceptionHandling()
           ->get('threads/create')
           ->assertRedirect('/login');		
	}

     /** @test **/ 
	function an_authenticated_user_can_create_a_forum_thread()
	{
		$this->signIn();

		$thread = make(Thread::class);

		$response = $this->post('/threads', $thread->toArray());

		$this->get($response->headers->get('Location'))
		      ->assertSee($thread->title);
	}

	  /** @test **/ 
	function a_thread_requires_a_title()
	{
        $this->publishThread()
             ->assertSessionHasErrors('title');

	}

    protected function publishThread()
    {
        $this->withExceptionHandling()->signIn();

        $thread = make(Thread::class, ['title' => null]);

        return $this->post('/threads', $thread->toArray());
               
    }

}


