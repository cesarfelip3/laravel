<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testLoginPage()
    {
        $user = factory(User::class)->create([
            'email' => 'user@user.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit(new Login)
                ->type('@email', $user->email)
                ->type('@password', 'secret')
                ->press('@submit');

            $browser->assertRouteIs('home');
        });
    }

    public function testGoToForgotYourPassword()
    {
        $this->browse(function ($browser) {
            $browser->visit(new Login)
                ->press("@forgotPassword")
                ->assertRouteIs('password.request');
        });
    }

}
