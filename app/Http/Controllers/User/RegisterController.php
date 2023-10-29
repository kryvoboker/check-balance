<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index() : Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $registerRequest)
    {

    }
}
