<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index() : Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.register');
    }

    /**
     * @param RegisterRequest $registerRequest
     * @return RedirectResponse|\Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function register(RegisterRequest $registerRequest) : RedirectResponse|\Illuminate\Contracts\Foundation\Application|Factory|View|Application
    {
        $user = User::create($registerRequest->all());

        if ($user) {
            Auth::login($user);

            return redirect()
                ->intended(route('success_register'));
        }

        return back()
            ->withErrors(['errors' => __('user/validation.error_fail_register')])
            ->withInput();
    }
}
