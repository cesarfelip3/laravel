<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Events\UserCreated' => [
            'App\Listeners\SendInvitation',
        ],
        'App\Events\UserUpdated' => [
            'App\Listeners\SendInvitation',
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
