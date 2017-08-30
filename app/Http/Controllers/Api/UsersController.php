<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;

class UsersController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->middleware('needsRole:admin');
        $this->service = $service;
    }

    public function index()
    {
        return User::all();
    }

    public function store(UserCreateRequest $request)
    {
        $data = $this->service->create($request->form());

        $response = [
            'message' => 'User created.',
            'data' => $data
        ];

        return $response;
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $obj = $this->service->update($request->form(), $user);

        $response = [
            'message' => 'User updated.',
            'data' => $obj,
        ];

        return $response;
    }

    public function destroy(User $user)
    {
        $this->service->delete($user);

        return [
            'message' => 'User deleted.'
        ];
    }
}
