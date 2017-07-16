<?php

namespace Tests\Unit;

use App\User;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserThreadTest extends TestCase
{
    use DatabaseMigrations;

     /** @test **/ 
    function a_user_can_create_a_thread()
    {
    	$user = factory(User::class)->create();

    	$thread = factory(Thread::class)->make();
        
        $user->makeThread($thread->toArray());
        $this->assertDatabaseHas('threads',[
        		'body' => $thread->body,
        		'title' => $thread->title
        	]);
    }
}
