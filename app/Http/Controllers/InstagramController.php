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


    public static function getUserUserId($celebrity, $nickname)
    {
        $response = self::get('/users/search', $celebrity->token, '&q=' . $nickname);

        if (count($response["data"]) <= 0) return false;

        return $response["data"][0]["id"];
    }

    public static function isFollower($follower_id, $celebrity)
    {
        $response = self::get('/users/self/followed-by', $celebrity->token);

        if (count($response["data"]) <= 0) return false;

        for ($i=0; $i < count($response["data"]); $i++) {
            if($response["data"][$i]["id"] == $follower_id) {
                return true;
            }
        }

        return false;
    }

    public static function hasRequested($follower_id, $celebrity)
    {
        $response = self::get('/users/self/requested-by', $celebrity->token);

        if (count($response["data"]) <= 0) return false;

        for ($i=0; $i < count($response["data"]); $i++) {
            if($response["data"][$i]["id"] == $follower_id) {
                return true;
            }
        }

        return false;
    }

    public static function isAccountPrivate($user)
    {
        $lastUser = User::where('id', '<>', $user->id)->first();

        if (!$lastUser) return true;

        return !InstagramController::userIsVisibleFrom($lastUser, $user);
    }

    public static function userIsVisibleFrom($follower, $celebrity)
    {
        try {
            $url = '/users/' . $celebrity->id . '/media/recent/';
            return self::get($url, $follower->token);
        } catch(RequestException  $e) {
            return false;
        } catch(Exception $e) {
            return false;
        }
    }

    public static function approve($celebrity, $follower_id)
    {
        $client = new \GuzzleHttp\Client();

        $res = $client->post(config('services.instagram.api_url') . '/users/' . $follower_id . '/relationship/?access_token=' . $celebrity->token, ['form_params' => [
            'action' => self::ACTION_APPROVE
        ]]);
    }

    public static function unfollow($celebrity, $follower_id)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->post(config('services.instagram.api_url') . '/users/' . $follower_id . '/relationship/?access_token=' . $celebrity->token, ['form_params' => [
            'action' => self::ACTION_IGNORE
        ]]);
    }

    public static function get($url, $token, $query = false)
    {
        $url = config('services.instagram.api_url') . $url . '?access_token=' . $token;
        if($query) {
            $url = $url . $query;
        }

        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);

        $data = json_decode($response->getBody(), true);
        return $data;
    }
}
