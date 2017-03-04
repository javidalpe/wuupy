<?php

namespace App\Http\Controllers;

use App\Subscription;
use \GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Jobs\ApproveRequests;

class SubscriptionController extends Controller
{

    public const STATUS_PENDING_ACTIVE = "pending_active";
    public const STATUS_ACTIVE = "active";
    public const STATUS_PENDING_INACTIVE = "pending_inactive";
    public const STATUS_INACTIVE  = "inactive";

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $data = [
            'user' => Auth::user(),
        ];

        return view('subscription.index', $data);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request, $username)
    {
        //Celebrity exits
        $celebrity = User::where('username', $username)->first();

        if (!$celebrity) abort(404);

        //Missed tokens
        if (!$request->has('stripeToken')) back()->with('error', 'Payment failed.');

        $follower_id = null;
        if (Auth::guest())
        {
            //Guest user, get from username
            $username = $request->input('username');

            if (!$username) {
                return back()->with('error', 'Who are you?! The username is required.');
            }

            if (!InstagramController::accountExists($request->input('username')))
                return back()->with('error', "Selected account doesn't exists.");

        } else {

            //Get from logged user
            $follower = Auth::user();
            $username = $follower->username;
            $follower_id = $follower->id;
        }

        //Follower and celebrity are the same
        if ($celebrity->id == $follower_id)  {
            return back()->with('error', 'You cannot follow yourself!');
        }

        $sub = Subscription::where('follower_username', '=', $username)->where('following_id', '=', $celebrity->id)->first();

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        try {

            if (!isset($follower) || !$follower->customer_id) {

                $email = $request->input('stripeEmail');

                $customer = \Stripe\Customer::create(array(
                    "description" => $username,
                    "email" => $email,
                    "source" => $request->input('stripeToken') // obtained with Stripe.js
                ));

                $customer_id = $customer->id;

                if (isset($follower)) {
                    $follower->customer_id = $customer_id;
                    $follower->email = $request->input('stripeEmail');
                    $follower->save();
                }

            } else {
                $customer_id = $follower->customer_id;
                $email = $follower->email;
            }

            $token = \Stripe\Token::create(array(
                "customer" => $customer_id,
            ), array("stripe_account" => $celebrity->account_id));

            $customer = \Stripe\Customer::create(array(
                "description" => $username,
                "email" => $email,
                "source" => $token->id
            ), array("stripe_account" => $celebrity->account_id));

            $subscription = \Stripe\Subscription::create(array(
                "customer" => $customer->id,
                "plan" => $celebrity->plan,
                "application_fee_percent" => config('plans.application_fee_percent'),
            ), array("stripe_account" => $celebrity->account_id));

            if(!$sub) {
                $sub = new Subscription;
                $sub->follower_username = $username;
                $sub->following_id = $celebrity->id;
            }

            $sub->customer_id = $customer->id;
            $sub->email = $email;
            $sub->subscription_id = $subscription->id;
            $sub->plan = $celebrity->plan;
            $sub->application_fee_percent = config('plans.application_fee_percent');
            $sub->status = self::STATUS_PENDING_ACTIVE;
            $sub->save();

            $request->session()->put('username', $username);

            return redirect()->route('subscriptions.done')->with('positive', 'You can now follow ' . $celebrity->name . '. The approval could take a few minutes.');

        } catch (\Stripe\Error\Base $e) {
            //InstagramController::unfollow($follower, $celebrity);
            return back()->with('error', $e->getMessage());
        } catch(RequestException  $e) {
            return back()->with('error', "There was an error following " . $username . ". Are you already following " . $username . "?");
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
    public function done()
    {
        $pending = Subscription::where('follower_username', '=', session('username'))
            ->where('status', '=', self::STATUS_PENDING_ACTIVE)
            ->get();

        return view('subscription.done', ['pending' => $pending]);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Subscription  $subscription
    * @return \Illuminate\Http\Response
    */
    public function show($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) abort(404);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        try {

            $account = \Stripe\Account::retrieve($user->account_id);
            $following = [];
            $isPublic = !InstagramController::isAccountPrivate($user->username);

            $data = [
                'user' => $user,
                'account' => $account,
                'following' => $following,
                'public' => $isPublic,
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
    public function destroy($id)
    {
        $subscription = Subscription::find($id);

        if (!$subscription) return back()->with('error', 'Account not found.');

        $celebrity = User::find($subscription->following_id);

        //InstagramController::unfollow(Auth::user(), $celebrity);

        if (!$celebrity) {
            $subscription->delete();
            return back()->with('error', 'Account not found.');
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $sub = \Stripe\Subscription::retrieve($subscription->subscription_id
            , array("stripe_account" => $celebrity->account_id));;
        $sub->cancel();

        //$subscription->delete();

        return back()->with('positive', 'Following cancelled.');

    }
}
