<?php

namespace Tests\Feature;

use App\User;
use App\Thread;
use App\Channel;
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
        $this->publishThread(['title' => null])
             ->assertSessionHasErrors('title');

	}

	  /** @test **/ 
	function a_thread_requires_a_body()
	{
		$this->publishThread(['body' => null])
		     ->assertSessionHasErrors('body');
	}

	  /** @test **/ 
	function a_threads_requires_a_valid_channel()
	{
		factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
             ->assertSessionHasErrors('channel_id');

         $this->publishThread(['channel_id' => 999])
         	  ->assertSessionHasErrors('channel_id');    		
	}

	  /** @test **/ 
	function it_a_thread_requires_a_user_id()
	{
		$this->publishThread(['user_id' =>null])
		  	  ->assertSessionHasErrors('user_id');		
	}
	

    protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make(Thread::class, $overrides);

        return $this->post('/threads', $thread->toArray());
               
    }

}


