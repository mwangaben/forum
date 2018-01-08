<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;

class NotifyThreadSubscribers
{
    /**
     * Handle the event.
     *
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        // Prepare notifications for all subscribers
        $event->thread->subscriptions->filter->subscribers($event->reply)->each->notify($event->reply);
    }
}
