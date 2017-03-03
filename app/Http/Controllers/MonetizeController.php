<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Tests\Browser\ExampleTest;

class MonetizeController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $user = Auth::user();

        ExampleTest::prepare();
        $test = new ExampleTest();
        $test->driver();
        $test->testBasicExample();

        //Account
        $account = null;
        $balance = [];
        if ($user->account_id) {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));


            try {
                $account = \Stripe\Account::retrieve($user->account_id);
                $balance = \Stripe\BalanceTransaction::all(array("limit" => 3), array("stripe_account" => $user->account_id))->data;
            } catch (\Stripe\Error\Base $e) {

                $user->account_id = null;
                $user->save();

                return back()->with('error', $e->getMessage());
            } catch (Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }


        $data = [
            'user' => $user,
            'account' => $account,
            'balance' => $balance,
        ];

        return view('monetize.index', $data);
    }
}
