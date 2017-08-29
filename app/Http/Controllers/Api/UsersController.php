<?php

namespace App\Http\Controllers\Api;

use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Notifications\UserInvited;
use App\Repositories\UserRepository;

class UsersController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->middleware('needsRole:admin');

        $this->repository = $repository;
    }

    public function index()
    {
        return $this->ok($this->repository->getNonClients());
    }

    public function store(UserCreateRequest $request)
    {
        $user = $this->repository->skipPresenter()->create($request->all());

        $response = [
            'message' => 'User created.'
        ];

        event(new UserCreated($user));

        return $this->ok($response);
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
