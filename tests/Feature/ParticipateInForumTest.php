<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{

	use DatabaseMigrations;

	  /** @test **/ 
	function an_authenticated_user_can_participate_in_a_forum()
	{    
		  // Given i have an authenticated user;
         $this->be(factory(User::class)->create());

          // And a Thread
         $thread = factory(Thread::class)->create();

          // When i post a reply on a thread
          
         $reply = factory(Reply::class)->make();
         $this->post($thread->path() .'/replies', $reply->toArray());	

         // Then I should see the reply
         $this->get($thread->path())
               ->assertSee($reply->body);
         
	}
    /** @test **/ 
  function unauthenticated_user_can_not_add_replies_on_threads()
  {
        $this->expectException('Exception');
        $thread = factory(Reply::class)->create();

        $reply = factory(Reply::class)->make();
        $this->post($thread->path(). '/replies', $reply->toArray());
  }
}
