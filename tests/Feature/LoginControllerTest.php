<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_requires_login()
    {
        $response = $this->get(route('home'));
        $response->assertRedirect(route('login'));
    }

}
