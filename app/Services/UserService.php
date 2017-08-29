<?php

namespace App\Services;


use App\Events\UserCreated;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;

class UserService
{
    public function create(UserCreateRequest $request)
    {
        return \DB::transaction(function () use ($request) {
            $data = [
                'name' => $request->name(),
                'email' => $request->email(),
                'invitation_token' => hash_hmac('sha256', str_random(40), config('APP_KEY')),
                'status' => false
            ];
            $user = new User($data);
            $user->save();

            $user->attachRole($request->role());

            event(new UserCreated($user));

            return $user;
        });
    }
}