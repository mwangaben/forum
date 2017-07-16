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
		$thread = factory(Thread::class)->make();

		$this->post('threads/store', $thread->toArray());
	}

     /** @test **/ 
	function an_authenticated_user_can_create_a_forum_thread()
	{
		$this->be(factory(User::class)->create());

		$thread = factory(Thread::class)->make();

		$this->post('threads/store', $thread->toArray());

		$this->get('threads')
		      ->assertSee($thread->title);
	}
}

