<?php

namespace App\Http\Controllers\Api;

use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;

class CurrentUserController extends Controller
{
    function __invoke(UserRepository $repository)
    {
        try {

            return $this->ok($repository->find(auth()->id()));
        } catch (\Exception $e) {

            return $this->fatal($e);
        }
    }
}
