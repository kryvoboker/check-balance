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
    /**
     * @return View
     */
    public function index() : View
    {
        return view('auth.register');
    }

    /**
     * @param RegisterRequest $registerRequest
     * @return RedirectResponse
     */
    public function register(RegisterRequest $registerRequest) : RedirectResponse
    {
        $user = User::create($registerRequest->all());

        if ($user) {
            return redirect(route('success_register'));
        }

        return back()
            ->withErrors(['errors' => __('user/validation.error_fail_register')])
            ->withInput();
    }
}
