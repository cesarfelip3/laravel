<?php

namespace App\Services;

use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;

class UserService
{
    public function create(UserCreateRequest $request): User
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

    public function update(UserUpdateRequest $request, User $user): User
    {
        return \DB::transaction(function () use ($request, $user) {
            $user->name = $request->name();
            $user->email = $request->email();
            $emailWasChanged = $user->isDirty('email');

            if ($user->role->id !== $request->role()->id) {
                $user->detachRole($user->role);
                $user->attachRole($request->role());
            }

            $user->save();

            event(new UserUpdated($user, $emailWasChanged));

            return $user;
        });
    }

    public function delete(User $user)
    {
        return \DB::transaction(function() use ($user) {
           $user->delete();

           event(new UserDeleted($user));
        });
    }
}