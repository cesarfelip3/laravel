<?php

namespace App\Services;

use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use App\Forms\UserForm;
use App\Models\User;

class UserService
{
    public function create(UserForm $form): User
    {
        return \DB::transaction(function () use ($form) {
            $data = [
                'name' => $form->name(),
                'email' => $form->email(),
                'invitation_token' => hash_hmac('sha256', str_random(40), config('APP_KEY')),
                'status' => false
            ];
            $user = new User($data);
            $user->save();

            $user->attachRole($form->role());

            event(new UserCreated($user));

            return $user;
        });
    }

    public function update(UserForm $form, User $user): User
    {
        return \DB::transaction(function () use ($form, $user) {

            if( $form->name() ) $user->name = $form->name();
            if( $form->email() ) $user->email = $form->email();
            $emailWasChanged = $user->isDirty('email');

            if ($form->role() && $user->role->id !== $form->role()->id) {
                $user->detachRole($user->role);
                $user->attachRole($form->role());
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