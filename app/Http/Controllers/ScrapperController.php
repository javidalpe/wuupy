<?php

namespace App\Http\Controllers;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class ScrapperController extends DuskTestCase
{
    const BASE = 'https://www.instagram.com';

    public function profileExits($nickname)
    {
        try {
            $this->browse(function (Browser $browser) use($nickname) {
                $browser->visit(self::BASE . '/' . $nickname)
    			         ->assertSee($nickname);
            });

        } catch(\PHPUnit_Framework_ExpectationFailedException $e) {
            return false;
        } finally {
            self::closeAll();
        }

        return true;
    }

    public function profilePrivate($nickname)
    {
        try {
            $this->browse(function (Browser $browser) use($nickname) {
                $browser->visit(self::BASE . '/' . $nickname)
                         ->assertSee('This Account is Private');

            });

        } catch(\PHPUnit_Framework_ExpectationFailedException $e) {
            return false;
        } finally {
            self::closeAll();
        }

        return true;
    }

    public function checkAuth($nickname, $password)
    {
        try {
            $this->browse(function (Browser $browser) use($nickname, $password) {

                    $this->login($browser, $nickname, $password)
                        ->visit(self::BASE . '/accounts/activity/')
            			->assertPathIs('/accounts/activity/');

            });
        } catch(\PHPUnit_Framework_ExpectationFailedException $e) {
            return false;
        } finally {
            self::closeAll();
        }

        return true;
    }

    private function login($browser, $nickname, $password)
    {
        return $browser->visit(self::BASE . '/accounts/login/')
            ->assertPathIs('/accounts/login/')
            ->waitForText('Log in')
            ->type('username', $nickname)
            ->type('password', $password)
            ->press('Log in')
            ->pause(2000);
    }


    public function follow($nickname, $password, $nicknames)
    {
        try {
            $this->browse(function (Browser $browser) use($nickname, $password, $nicknames) {

                $this->login($browser, $nickname, $password)
                    ->visit(self::BASE . '/accounts/activity/')
        			->assertPathIs('/accounts/activity/')
        			->waitForLink('Follow Requests')
        			->clickLink('Follow Requests');

                $processed = [];

                for ($i=2; $i < 100; $i++) {
                    try {
                        $browser->with('._mkiio:nth-child(' . $i . ')', function ($li) use($nicknames, $processed) {
                            
                            $text = $li->text('._gpve0');

                            if (!in_array($text, $processed)) {
                                if(in_array($text, $nicknames)) {
                    			     $li->press('Approve');
                                 } else {
                     			     $li->press('Hide');
                                 }
                             }

                             array_push($processed, $text);

                         });
                     } catch(\Facebook\WebDriver\Exception\NoSuchElementException $exc) {
                         break;
                     }
                }

            });
        } catch(\Facebook\WebDriver\Exception\TimeOutException $e) {

        } finally {
           self::closeAll();
        }

    }
}
