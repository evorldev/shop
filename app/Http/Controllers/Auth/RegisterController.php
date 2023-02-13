<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function page()
    {
        return view('auth.register');
    }

    public function handle(RegisterFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        $action(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );

        return redirect()->intended(route('home'));
    }
}
