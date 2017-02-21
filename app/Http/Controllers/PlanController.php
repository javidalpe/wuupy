<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PlanController extends Controller
{
    public function store(Request $request)
    {
      $user = Auth::user();
      $user->plan = $request->input('plan');
      $user->save();

      return redirect('/home');
    }
}
