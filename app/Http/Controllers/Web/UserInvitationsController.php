<?php

namespace App\Http\Controllers\Web;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class UserInvitationsController extends Controller
{
    public function __invoke(UserRepository $repository, $token)
    {
        $isValid = $repository->invitationTokenIsValid($token);

        return view('auth.invitation', compact('isValid', 'token'));
    }
}
