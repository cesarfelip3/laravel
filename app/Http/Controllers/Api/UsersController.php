<?php

namespace App\Http\Controllers\Api;

use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Jobs\CreateUser;
use App\Models\User;
use App\Notifications\UserInvited;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('needsRole:admin');
    }

    public function index()
    {
        return User::all();
    }

    public function store(UserCreateRequest $request)
    {
        //

//        $user = new User(['name' => $this->name, 'email' => $this->email]);
//        $user->invitation_token = hash_hmac('sha256', str_random(40), config('APP_KEY'));
//        $user->save();
//        $user->attachRole($this->role);
//
//        event(new UserCreated($user));


        $response = [
            'message' => 'User created.'
        ];

        return $response;
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $obj = $this->repository->update($request->all(), $id);

        $response = [
            'message' => 'User updated.',
            'data' => $obj,
        ];

        return $this->ok($response);
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        return $this->ok([
            'message' => 'User deleted.',
            'deleted' => $deleted,
        ]);
    }
}
