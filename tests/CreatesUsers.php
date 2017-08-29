<?php

namespace Tests;

use App\Models\User;
use Artesaos\Defender\Role;
use Defender;
use Laravel\Passport\Passport;

trait CreatesUsers
{
    protected function login(array $attributes = [], $role): User
    {
        $user = $this->createUser($attributes, $role);

        $this->loginAs($user);

        return $user;
    }

    protected function loginAs(User $user)
    {
        Passport::actingAs($user);
        $this->be($user);
    }

    protected function loginAsSuperAdmin(array $attributes = []): User
    {
        return $this->login($attributes, User::SUPERADMIN);
    }

    protected function loginAsAdmin(array $attributes = []): User
    {
        return $this->login($attributes, User::ADMIN);
    }

    protected function loginAsUser(array $attributes = []): User
    {
        return $this->login($attributes, User::USER);
    }


    protected function createSuperAdminUser(array $attributes = []): User
    {
        return $this->createUser($attributes, User::SUPERADMIN);
    }

    protected function createAdminUser(array $attributes = []): User
    {
        return $this->createUser($attributes, User::ADMIN);
    }

    protected function createUserUser(array $attributes = []): User
    {
        return $this->createUser($attributes, User::USER);
    }


    protected function createUser(array $attributes = [], $role): User
    {
        /** @var User $user */
        $user = factory(User::class)->create(array_merge([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ], $attributes));

        $role = $this->createRole($role);

        $user->attachRole($role);
        $user->load('roles');
        return $user;
    }

    protected function createRole($role): Role
    {
        return Defender::createRole($role);
    }

    protected function createAdminRole(): Role
    {
        return $this->createRole(User::ADMIN);
    }

    protected function createSuperAdminRole(): Role
    {
        return $this->createRole(User::SUPERADMIN);
    }

    protected function createUserRole()
    {
        return $this->createRole(User::USER);
    }
}