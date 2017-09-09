<?php

namespace Tests\Unit;

use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test **/
    public function a_reply_has_a_owner()
    {
        $reply = factory(Reply::class)->create();
        $this->assertInstanceOf('App\User', $reply->owner);
    }

    /** @test **/
    public function unauthorized_can_not_delete_a_reply()
    {
        $this->withExceptionHandling();
        $reply = create(Reply::class);
        $this->delete('replies/' . $reply->id)
            ->assertRedirect('/login');

        $this->signIn()
            ->delete('replies/' . $reply->id)
            ->assertStatus(403);
    }
    /** @test **/
    public function unauthorized_can_not_update_a_reply()
    {
        $this->withExceptionHandling();
        $reply = create(Reply::class);
        $this->patch('replies/' . $reply->id)
            ->assertRedirect('/login');

        $this->signIn()
            ->patch('replies/' . $reply->id)
            ->assertStatus(403);
    }

    /** @test **/
    public function authorized_user_can_delete_a_reply()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete('replies/' . $reply->id);
        $this->assertDatabaseMissing('replies', [
            'body'    => $reply->body,
            'user_id' => auth()->id(),
        ]);

    }

      /** @test **/ 
    function it_authorised_user_can_update_the_reply()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]) ;

        $updatedReply  = 'Let us talk later' ;

        $this->patch('replies/'.$reply->id, ['body' => $updatedReply]);
        $this->assertDatabaseHas('replies',['body' => $updatedReply]);     
    }
}
