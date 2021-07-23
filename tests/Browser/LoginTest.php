<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('LOGIN')
                ->value('#username', 'gomez')
                ->value('#password', 'admin')
                ->click('button[type="submit"]')
                ->assertPathIs('/admin');
        });
    }
}
