<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function page()
    {
        return view('auth.register');
    }

    public function handle(RegisterFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        $action(NewUserDTO::fromRequest($request));

        return redirect()->intended(route('home'));
    }
}
