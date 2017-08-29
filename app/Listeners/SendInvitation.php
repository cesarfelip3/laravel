<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Notifications\UserInvited;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvitation implements ShouldQueue
{
    /**
     * @param UserCreated|UserUpdated $event
     */
    public function handle($event)
    {
        if( $event->sendInvite ) {
            $event->user->notify(new UserInvited($event->user));
        }
    }
}
