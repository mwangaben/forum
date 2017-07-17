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
    	  $this->thread = create(Thread::class);
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
    function a_thread_has_a__reply()
    {
        $this->thread->addReply([
            'body' => 'Foo',
            'user_id' => 1
            ]);
       $this->assertCount(1, $this->thread->replies);
    }

     /** @test **/ 
    function a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

      /** @test **/ 
    function it_a_thread_can_make_a_string_path()
    {
        $this->assertEquals('/threads/'.$this->thread->channel->slug .'/'. $this->thread->id,$this->thread->path());       
    }


     
      
}
