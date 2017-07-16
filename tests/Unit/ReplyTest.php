<?php

namespace Tests\Unit;

use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReplyTest extends TestCase
{
	use DatabaseMigrations;

	  /** @test **/ 
	function a_reply_has_a_owner()
	{
        $reply = factory(Reply::class)->create();
        $this->assertInstanceOf('App\User', $reply->owner);		
	}
}
