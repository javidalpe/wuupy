<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;
use App\User;
use Auth;

class SubscriptionController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        if (Auth::user()->customer_id) {
            $subscriptions = \Stripe\Subscription::all(array('customer'=> Auth::user()->customer_id));
        } else {
            $subscriptions = array();
        }

        $data = [
            'subscriptions' => $subscriptions,
        ];

        return view('subscription.index', $data);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create($nickname)
    {
        if (Auth::guest())
        {
            session(['follow' => $nickname]);
            return redirect('login');
        }

        $user = User::where('nickname', $nickname)->first();

        if (!$user) abort(404);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $account = \Stripe\Account::retrieve($user->account_id);

        $data = [
            'user' => $user,
            'account' => $account,
        ];

        return view('subscription.create', $data);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request, $nickname)
    {
        $celebrity = User::where('nickname', $nickname)->first();

        if (!$celebrity) abort(404);

        $follower = Auth::user();

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        try {
            if (!$follower->customer_id) {
                $customer = \Stripe\Customer::create(array(
                    "description" => $follower->nickname,
                    "email" => $request->input('stripeEmail'),
                    "source" => $request->input('stripeToken') // obtained with Stripe.js
                ));
                $customer_id = $customer->id;

                $follower->customer_id = $customer_id;
                $follower->email = $request->input('stripeEmail');
                $follower->save();

            } else {
                $customer_id = $follower->customer_id;
            }

            $token = \Stripe\Token::create(array(
              "customer" => $customer_id,
            ), array("stripe_account" => $celebrity->account_id));

            $customer = \Stripe\Customer::create(array(
                "description" => $follower->nickname,
                "email" => $follower->email,
                "source" => $token->id
            ), array("stripe_account" => $celebrity->account_id));

            $subscription = \Stripe\Subscription::create(array(
                "customer" => $customer->id,
                "plan" => $celebrity->plan,
                "application_fee_percent" => 15,
            ), array("stripe_account" => $celebrity->account_id));


            return redirect('https://www.instagram.com/' . $nickname . '/');


        } catch (\Stripe\Error\Base $e) {
            return back()->with('error', $e->getMessage());
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Subscription  $subscription
    * @return \Illuminate\Http\Response
    */
    public function show($nickname)
    {
        $user = User::where('nickname', $nickname)->first();

        if (!$user) abort(404);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $account = \Stripe\Account::retrieve($user->account_id);

            $data = [
                'user' => $user,
                'account' => $account,
            ];

            return view('subscription.show', $data);

        } catch (\Stripe\Error\Base $e) {
            return back()->with('error', $e->getMessage());
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Subscription  $subscription
    * @return \Illuminate\Http\Response
    */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Subscription  $subscription
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Subscription  $subscription
    * @return \Illuminate\Http\Response
    */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
