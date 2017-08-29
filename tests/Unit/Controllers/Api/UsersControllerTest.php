<?php

namespace Tests\Unit;

use App\Events\UserCreated;
use App\Models\User;
use App\Notifications\UserInvited;
use Event;
use Notification;
use Symfony\Component\HttpFoundation\Response;
use Tests\CreatesUsers;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_super_admins_can_get_a_list_of_users()
    {
        $this->loginAsSuperAdmin();
        $this->assertGetUsersWithStatus(Response::HTTP_OK);
    }

    public function test_admins_can_get_a_list_of_users()
    {
        $this->loginAsAdmin();
        $this->assertGetUsersWithStatus(Response::HTTP_OK);
    }

    public function test_users_can_not_get_list_of_users()
    {
        $this->loginAsUser();
        $this->assertGetUsersWithStatus(Response::HTTP_FOUND);
    }

    private function assertGetUsersWithStatus($status)
    {
        $response = $this->get(route('api.user.index'));
        $response->assertStatus($status);
    }

    public function test_admin_can_create_a_user()
    {
        $response = $this->createUserUsingTheApi()->response;

        $response->assertSuccessful();
        $this->assertDatabaseHas('users', ['name' => 'Jeremias']);
    }

    public function test_the_event_dispatched_when_creating_an_user()
    {
        Event::fake();
        $this->createUserUsingTheApi();
        Event::assertDispatched(UserCreated::class);
    }

    public function test_the_notification_sent_for_a_new_user()
    {
        Notification::fake();
        $user = $this->createUserUsingTheApi()->user;
        Notification::assertSentTo($user, UserInvited::class);
    }

    public function test_admin_can_update_a_user()
    {
        $this->loginAsAdmin();

        $user = $this->createUserUser(['email' => 'jane@example.com']);
        $user->name = 'Jeremias';

        $route = route('api.user.update', ['user' => $user->id]);
        $response = $this->put($route, $user->toArray());

        $response->assertSuccessful();
        $this->assertDatabaseHas('users', ['name' => 'Jeremias']);
    }

    public function test_admin_can_delete_a_user()
    {
        $this->loginAsAdmin();

        $user = $this->createUserUser(['email' => 'jane@example.com']);

        $response = $this->delete(route('api.user.destroy', ['user' => $user->id]));

        $this->assertDatabaseMissing('users', ['email' => 'jane@example.com']);
        $response->assertSuccessful();
    }

    protected function createUserUsingTheApi(): \stdClass
    {
        $this->loginAsAdmin();
        $newUser = factory(User::class)->make(['name' => 'Jeremias']);
        $arrayUser = $newUser->toArray();
        $role = $this->createUserRole();
        $arrayUser['role'] = $role->toArray();
        $postRequest = $this->post(route('api.user.store'), $arrayUser);
        $newUser = $postRequest->decodeResponseJson()['data'];
        $newUser = User::find($newUser['id']);
        return (object)[
            'response' => $postRequest,
            'user' => $newUser
        ];
    }
}
