<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CurrentUserController extends Controller
{
    function __invoke()
    {
        return auth()->user();
    }
}
