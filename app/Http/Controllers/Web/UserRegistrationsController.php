<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\UserRegistrationRequest;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserRegistrationsController extends Controller
{
    public function __invoke(UserRegistrationRequest $request)
    {
        $user = User::byToken(request('invitation_token'));

        if (!$user)
            return route('home');

        $user->password = bcrypt(request('password'));
        $user->invitation_token = null;
        $user->save();

        auth()->login($user);

        return redirect('/')
            ->with('welcome', true);
    }
}
