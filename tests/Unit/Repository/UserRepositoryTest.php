<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repositories\UserRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations;


    public function test_can_create_user_with_a_role()
    {

        $repository = app(UserRepository::class);

        $role = \Defender::createRole('admin');

        $user = factory(User::class)->make()->toArray();
        $user['role'] = $role->toArray();

        $repository->create($user);

        /** @var User $user */
        $user = $repository->skipPresenter()->all()->first();
        $user->load(['roles']);
        $this->assertTrue($user->hasRole($role->name));
    }
}
