<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Notifications\UserInvited;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvitation implements ShouldQueue
{
    public function handle(UserCreated $event)
    {
        $event->user->notify(new UserInvited($event->user));
    }
}
