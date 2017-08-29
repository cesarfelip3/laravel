<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\UserRegistrationRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;

class UserRegistrationsController extends Controller
{
    public function __invoke(
        UserRepository $repository,
        UserRegistrationRequest $request
    )
    {
        $user = $repository->getUserByToken(request('invitation_token'));

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
