<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SpotifyLinkController extends Controller
{
    public function redirectToAuthentication(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver('spotify')
            ->scopes(['user-library-read'])
            ->redirect();
    }

    public function authenticationCallback()
    {
        $provider = 'spotify';
        $user = Auth::user();
        $spotifyUser = Socialite::driver($provider)->user();

        $user->saveOauthProviderToken($provider, $spotifyUser);

        return redirect("/dashboard");
    }

    public function unlinkAccount()
    {
        $user = Auth::user();
        $user->removeOauthProviderToken('spotify');
        return response(null, 204);
    }
}
