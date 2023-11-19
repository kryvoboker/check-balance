<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() : View
    {
        return view('auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request) : RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        $has_errors = $request->session()->has('errors');

        if (!$has_errors && Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('costs.index'))
                ->with(['message_success' => __('user/login.success')]);
        }

        if (!$has_errors) {
            return back()
                ->withErrors(['errors' => __('user/login.error_user_not_exists')])
                ->onlyInput('email');
        } else {
            return back()
                ->withErrors(['errors' => $request->session()->get('errors')])
                ->onlyInput('email');
        }
    }
}
