<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function index() : Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.register');
    }

    /**
     * @param RegisterRequest $registerRequest
     * @return RedirectResponse
     */
    public function register(RegisterRequest $registerRequest) : RedirectResponse
    {
        User::create($registerRequest->all());

        return redirect()
            ->intended('/');
    }
}
