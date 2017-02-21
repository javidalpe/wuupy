<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class MonetizeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $account = null;
      if (Auth::user()->account_id) {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $account = \Stripe\Account::retrieve(Auth::user()->account_id);
      }
      return view('monetize.index', ['account' => $account]);
  }
}
