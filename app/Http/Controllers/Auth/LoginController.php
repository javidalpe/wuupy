<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use \GuzzleHttp\Exception\RequestException;
use Socialite;
use App\User;
use Auth;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('instagram')->scopes(['public_content', 'relationships'])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $instagramUser = Socialite::driver('instagram')->user();
        } catch(\Laravel\Socialite\Two\InvalidStateException  $e) {
            return redirect('/');
        } catch(RequestException  $e) {
            return redirect('/');
        } catch (Exception $e) {
            return redirect('/');
        }


        $user = User::find($instagramUser->id);
        if (!$user) {
            $user = new User;
        }

        $user->id = $instagramUser->id;
        $user->token = $instagramUser->token;
        $user->refreshToken = $instagramUser->refreshToken;
        $user->expiresIn = $instagramUser->expiresIn;
        $user->nickname = $instagramUser->nickname;
        $user->name = $instagramUser->name;
        $user->email = $instagramUser->email;
        $user->avatar = $instagramUser->avatar;
        $user->user = json_encode($instagramUser->user);
        $user->save();

        Auth::login($user, true);

        if (session('follow')) {
          return redirect()->route('subscriptions.create', session('follow'));
        }

        return redirect('/home');
    }
}
