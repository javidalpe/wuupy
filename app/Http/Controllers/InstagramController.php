<?php

namespace App\Http\Controllers;

use \GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Auth;
use App\User;

class InstagramController extends Controller
{
    public const ACTION_FOLLOW = 'follow';
    public const ACTION_UNFOLLOW = 'unfollow';
    public const ACTION_APPROVE = 'approve';
    public const ACTION_IGNORE = 'ignore';

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

    public static function isAccountPrivate($user)
    {
        $lastUser = User::where('id', '<>', $user->id)->first();

        if (!$lastUser) return false;

        return !InstagramController::userIsVisibleFrom($lastUser, $user);
    }

    public static function userIsVisibleFrom($follower, $celebrity)
    {
        $url = config('services.instagram.api_url') . '/users/' . $celebrity->id . '/media/recent/?access_token=' . $follower->token;
        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->get($url);
            return true;
        } catch(RequestException  $e) {
            return false;
        } catch(Exception $e) {
            return false;
        }
    }

    public static function follow($follower, $celebrity)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->post(config('services.instagram.api_url') . '/users/' . $celebrity->id . '/relationship/?access_token=' . $follower->token, ['form_params' => [
            'action' => self::ACTION_FOLLOW
        ]]);
        $res = $client->post(config('services.instagram.api_url') . '/users/' . $follower->id . '/relationship/?access_token=' . $celebrity->token, ['form_params' => [
            'action' => self::ACTION_APPROVE
        ]]);

    }

    public static function unfollow($follower, $celebrity)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->post(config('services.instagram.api_url') . '/users/' . $celebrity->id . '/relationship/?access_token=' . $follower->token, ['form_params' => [
            'action' => self::ACTION_UNFOLLOW
        ]]);
    }
}
