<?php

namespace Tests\Unit;

use App\Forms\UserForm;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Tests\Fakers\FormRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create()
    {
        $this->loginAsAdmin();
        $role = $this->createUserRole();

        $service = new UserService();
        $attributes = [
            'name' => 'Jeremias',
            'email' => 'jeremias@test.com',
            'role' => $role->toArray()
        ];

        $form = new UserForm(new FormRequest($attributes));

        $service->create($form);

        $this->assertDatabaseHas('users', ['name' => 'Jeremias']);
    }

    public function test_update()
    {
        $this->loginAsAdmin();
        $role = $this->createUserRole();

        $service = new UserService();
        $attributes = [
            'name' => 'Jeremias',
            'email' => 'jeremias@test.com',
            'role' => $role->toArray()
        ];

        $form = new UserForm(new FormRequest($attributes));

        $user = $service->create($form);
        $this->assertDatabaseHas('users', ['name' => 'Jeremias']);

        $attributes['name'] = 'Robert';
        $form = new UserForm(new FormRequest($attributes));

        $service->update($form, $user);

        $this->assertDatabaseHas('users', ['name' => 'Robert']);
    }

    public function test_delete()
    {
        $this->loginAsAdmin();
        $role = $this->createUserRole();

        $service = new UserService();
        $attributes = [
            'name' => 'Jeremias',
            'email' => 'jeremias@test.com',
            'role' => $role->toArray()
        ];

        $form = new UserForm(new FormRequest($attributes));

        $user = $service->create($form);
        $this->assertDatabaseHas('users', ['name' => 'Jeremias']);

        $service->delete($user);

        $this->assertDatabaseMissing('users', ['name' => 'Jeremias']);
    }


}
