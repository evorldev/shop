<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteAuthController extends Controller
{
    public function redirect(string $driver)
    {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (\Throwable $th) {
            throw new \DomainException('Произошла ошибка или драйвер не поддерживается.');
        }
    }

    public function callback(string $driver)
    {
        if ($driver !== 'github') {
            throw new \DomainException('Драйвер не поддерживается.');
        }

        $githubUser = Socialite::driver($driver)->user();

        $user = User::updateOrCreate([
            $driver . '_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'password' => bcrypt(str()->random(20)),
            // 'github_token' => $githubUser->token,
            // 'github_refresh_token' => $githubUser->refreshToken,
        ]);

        Auth::login($user);

        return redirect()->intended(route('home'));;
    }
}
