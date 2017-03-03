<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('https://instagram.com');
            $browser->clickLink('Log in');

            $browser->type('username', 'javidalpe')
                    ->type('password', 'ij825675pm')
                    ->press('Log in')
                    ->assertPathIs('https://www.instagram.com/');
        });
    }
}
