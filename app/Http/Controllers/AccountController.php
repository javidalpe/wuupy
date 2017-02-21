<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AccountController extends Controller
{
  public function store(Request $request)
  {
    $user = Auth::user();

    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    $response = \Stripe\Account::create(
      array(
        "country" => $request->input('country'),
        "managed" => true,
        "tos_acceptance"=> [
          "date"=> time(),
          "ip"=> $request->ip(),
          "user_agent"=> $request->header('User-Agent')
        ],
        "legal_entity"=> [
          "type"=> $request->input('type'),
        ],
      )
    );

    $account_id = $response['id'];

    \Stripe\Plan::create(array(
      "amount" => config('plans.one'),
      "interval" => "month",
      "name" => "One dollar plan",
      "currency" => "usd",
      "id" => "one"
    ), array("stripe_account" => $account_id));

    \Stripe\Plan::create(array(
      "amount" => config('plans.five'),
      "interval" => "month",
      "name" => "Five dollars plan",
      "currency" => "usd",
      "id" => "five"
    ), array("stripe_account" => $account_id));

    \Stripe\Plan::create(array(
      "amount" => config('plans.ten'),
      "interval" => "month",
      "name" => "Ten dollars plan",
      "currency" => "usd",
      "id" => "ten"
    ), array("stripe_account" => $account_id));

    \Stripe\Plan::create(array(
      "amount" => config('plans.twenty'),
      "interval" => "month",
      "name" => "Twenty dollars plan",
      "currency" => "usd",
      "id" => "twenty"
    ), array("stripe_account" => $account_id));

    $user->account_id = $account_id;
    $user->save();

    return redirect('/home');
  }
}
