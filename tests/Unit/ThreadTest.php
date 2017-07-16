<?php

namespace Tests\Unit;

use App\User;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    /** @test **/
    public function setUp()
    {
    	  parent::setUp();
    	  $this->thread = factory(Thread::class)->create();
    }
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',
            $this->thread->replies);
    }
  
       /** @test **/ 
     public function a_thread_has_a_creator()
     {
     	  $this->assertInstanceOf(User::class, $this->thread->creator);
     }

       /** @test **/ 
    function a_thread_can_a_adda_reply()
    {
        $this->thread->addReply([
            'body' => 'Foo',
            'user_id' => 1
            ]);
       $this->assertCount(1, $this->thread->replies);
    }
     
      
}
