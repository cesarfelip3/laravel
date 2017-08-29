<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Http\Controllers\Controller;

class UserInvitationsController extends Controller
{
    public function __invoke($token)
    {
        $isValid = User::invitationTokenIsValid($token);

        return view('auth.invitation', compact('isValid', 'token'));
    }
}
