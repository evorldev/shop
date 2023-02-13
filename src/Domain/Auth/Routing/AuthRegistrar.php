<?php

namespace Domain\Auth\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialiteAuthController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class AuthRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function() {
            Route::controller(LoginController::class)->group(function () {
                Route::get('/login', 'page')
                    ->middleware(['guest'])
                    ->name('login');
                Route::post('/login', 'handle')
                    ->middleware(['guest', 'throttle:auth'])
                    ->name('login.handle');

                Route::delete('/logout', 'logout')->name('logout');
            });

            Route::controller(RegisterController::class)->group(function () {
                Route::get('/register', 'page')->name('register');
                Route::post('/register', 'handle')
                    ->middleware('throttle:auth')
                    ->name('register.handle');
            });

            Route::controller(ForgotPasswordController::class)->group(function () {
                Route::get('/forgot-password','page')
                    ->middleware('guest')
                    ->name('forgot-password');

                Route::post('/forgot-password', 'handle')
                    ->middleware('guest')
                    ->name('forgot-password.handle');
            });

            Route::controller(ResetPasswordController::class)->group(function () {
                Route::get('/reset-password/{token}', 'page')
                    ->middleware('guest')
                    ->name('password.reset');

                Route::post('/reset-password', 'handle')
                    ->middleware('guest')
                    ->name('reset-password.handle');
            });

            Route::controller(SocialiteAuthController::class)->group(function () {
                Route::get('/auth/socialite/{driver}', 'redirect')
                    ->name('socialite.redirect');

                Route::get('/auth/socialite/{driver}/callback', 'callback')
                    ->name('socialite.callback');
            });
        });
    }
}
