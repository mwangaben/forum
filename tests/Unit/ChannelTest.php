<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ChannelTest extends TestCase
{

    use DatabaseMigrations;

    /** @test **/
    public function a_channel_has_threads()
    {
        $channel = create(Channel::class);

        $thread = create(Thread::class, ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
        $this->assertDatabaseHas('threads', [
            'channel_id' => $channel->id,
            'body'       => $thread->body,
            'title'      => $thread->title,
        ]);
    }
}
