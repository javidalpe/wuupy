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

        if(!$user->username)
            return back()->with("error", "Connect your Instagram account first.");

        $private = InstagramController::isAccountPrivate($user->username);
        $user->private_checked = $private;
        $user->save();

        if (!$private) {
            return redirect("/home#3")->with("error", "Your account is still publicly reachable.");
        }
        return redirect("/home#3");
    }

    public function connect(Request $request)
    {
        $user = Auth::user();

        $controller = new ScrapperController();

        if(!$controller->checkAuth($request->input('username'), $request->input('pass')))
            return back()->with("error", "Invalid credentials.");

        $user->username = $request->input('username');
        $user->pass = encrypt($request->input('pass'));
        $user->save();

        return back();

    }


    public static function accountExists($username)
    {
        $controller = new ScrapperController();
        return $controller->profileExits($username);
    }

    public static function isAccountPrivate($username)
    {
        $controller = new ScrapperController();
        return $controller->profilePrivate($username);
    }
}
