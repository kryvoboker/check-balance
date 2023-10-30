<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() : Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request) : RedirectResponse
    {
        if (Auth::attempt($request->all())) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with(['message_success' => __('user/login.success')]);
        }

        return redirect()
            ->intended(route('login'))
            ->withErrors(['errors' => __('user/login.error_user_not_exists')])
            ->withInput();
    }
}
