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
            $browser->visit('https://www.instagram.com/accounts/login/')
    			->assertPathIs('/accounts/login/')
		        ->waitForText('Log in')
            	->type('username', 'javidalpe')
                ->type('password', 'ij825675pm')
                ->press('Log in');

		$browser->pause(2000);

		$browser->visit('https://www.instagram.com/accounts/activity/')
			->assertPathIs('/accounts/activity/')
			->waitForLink('Follow Requests')
			->clickLink('Follow Requests')
			->assertSee('j.carlos_life');


		$text = $browser->text('a._4zhc5.notranslate._gpve0');
		if($text=='estelasailing')
			$browser->press('Approve');
        });
    }
}
