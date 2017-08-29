<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class Users extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/users';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs('/users');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@add' => '[role=addUser]',
            '@edit' => 'button[role=editUser]',
            '@editSecond' => 'button[role=editUser]:nth-child(2)',
            '@destroy' => 'button[role=destroyUser]:nth-child(2)',
            '@destroySecond' => 'button[role=destroyUser]:nth-child(2)',
            '@formName' => 'input#name',
            '@formEmail' => 'input#email',
            '@formRole' => 'select#role',
            '@formPassword' => 'input#password',
        ];
    }
}
