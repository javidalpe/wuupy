<?php

namespace App\Http\Controllers;

use \GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Auth;
use App\User;

class InstagramController extends Controller
{

    public function check()
    {
        $user = Auth::user();

        $private = InstagramController::isAccountPrivate($user);
        $user->private_checked = $private;
        $user->save();

        if (!$private) {
            return redirect("/home#3")->with("error", "Your account is still publicly reachable.");
        }
        return redirect("/home#3");
    }


    public static function accountExists($username)
    {
        return true;
    }

    public static function isAccountPrivate($user)
    {
        return true;
    }

    public function connect(Request $request)
    {
        $user = Auth::user();

        $user->username = $request->input('username');
        $user->pass = encrypt($request->input('pass'));
        $user->save();

        return back();
    }
}
