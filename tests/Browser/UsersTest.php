<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\Browser\Pages\Users;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUsersList()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use( $user ) {
            $browser->loginAs($user->id)
                    ->visit(new Users)
                    ->waitFor('@edit');
        });
    }

    public function testAddingNewUser()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use( $user ) {
            $browser->loginAs($user->id)
                ->visit(new Users)
                ->pressAndWaitFor('@add', 3)
                ->type('#name', 'Jeremias')
                ->press('Save');

            $browser->waitForText('Jeremias');
        });

    }
}
