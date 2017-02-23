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
      $account = null;
      if ($user->account_id) {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $account = \Stripe\Account::retrieve($user->account_id);
      }
      $data = [
        'user' => $user,
        'account' => $account,
        'ready' => $account && $account['transfers_enabled'],
      ];
      return view('monetize.index', $data);
  }
}
