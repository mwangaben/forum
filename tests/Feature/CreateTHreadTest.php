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

		$this->post('/threads', $thread->toArray());

		$this->get('threads')
		      ->assertSee($thread->title);
	}
}


