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
      $user = Auth::user();

      //Account
      $account = null;
      $transfers = [];
      if ($user->account_id) {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $account = \Stripe\Account::retrieve($user->account_id);
        $transfers = \Stripe\Transfer::all(array("limit" => 15))->data;
      }


      $data = [
        'user' => $user,
        'account' => $account,
        'transfers' => $transfers,
      ];

      return view('monetize.index', $data);
  }
}
