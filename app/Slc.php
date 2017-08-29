<?php

namespace App;

class Slc
{
    public static function scriptVariables()
    {
        return [
            'user' => self::getCurrentUser(),
            'csrfToken' => csrf_token()
        ];
    }

    public static function getCurrentUser()
    {
        if (auth()->guest()) return null;
        return auth()->user()->toArray();
    }
}
