<?php

namespace Tests\Unit;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use App\Services\UserService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create()
    {
        $this->loginAsAdmin();
        $this->createUserRole();
        $role = \Defender::findRole(User::USER);

        $service = new UserService();
        $attributes = [
            'name' => 'Jeremias',
            'email' => 'jeremias@test.com',
            'role' => $role->toArray()
        ];
        $request = new UserCreateRequest($attributes);
        $service->create($request);

        $this->assertDatabaseHas('users', ['name' => 'Jeremias']);
    }
}
