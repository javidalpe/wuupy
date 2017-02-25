<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class BalanceController extends Controller
{
    public function index()
    {
      $user = Auth::user();

      //Account
      $balance = [];
      if ($user->account_id) {
          \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

          try {
              $balance = \Stripe\BalanceTransaction::all(array(), array("stripe_account" => $user->account_id))->data;
          } catch (\Stripe\Error\Base $e) {

              return back()->with('error', $e->getMessage());
          } catch (Exception $e) {
              return back()->with('error', $e->getMessage());
          }
      }


      $data = [
          'user' => $user,
          'balance' => $balance,
      ];

      return view('monetize.balance.index', $data);
    }
}
