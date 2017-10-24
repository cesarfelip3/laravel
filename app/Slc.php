<?php

namespace App;

class Slc
{
    public static function scriptVariables()
    {
        return [
            'user' => self::getCurrentUser(),
            'csrfToken' => csrf_token(),
            'pusher_app_key' => env('PUSHER_APP_KEY'),
            'stripe_key' => env('STRIPE_KEY'),
        ];
    }

    public static function getCurrentUser()
    {
        if (auth()->guest()) return null;
        return auth()->user()->toArray();
    }
}
