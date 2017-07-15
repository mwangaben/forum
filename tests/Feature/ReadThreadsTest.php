<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;
    protected $thread;
    public function setUp()
    {
          parent::setUp();
          $this->thread = factory(Thread::class)->create();
    }
      /** @test **/ 
    function a_user_can_browse_all_threads()
    {

        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

      /** @test **/ 
    function a_user_can_browse_a_single_thread()
    {
        $this->get($this->thread->path())
             ->assertSee($this->thread->title);        
    }

    /** @test **/ 
    function it_a_user_can_read_replies_that_are_associated_with_the_thread()
    {
        $reply = factory(Reply::class)->create(['thread_id'=> $this->thread->id]); 
        $this->get($this->thread->path())
             ->assertSee($reply->body);       
    }


}
