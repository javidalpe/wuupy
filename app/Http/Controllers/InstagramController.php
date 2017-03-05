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

        try {

            $controller->checkAuth($request->input('username'), $request->input('pass'));

            $user->username = $request->input('username');
            $user->pass = encrypt($request->input('pass'));
            $user->save();

            return back();

        } catch(InvalidPasswordException $e) {
            return back()->with("error", "Sorry, your password was incorrect. Please double-check your password.");
        } catch(InvalidUsernameException $e) {
            return back()->with("error", "The username you entered doesn't belong to an account. Please check your username and try again.");
        }
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
