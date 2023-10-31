<?php

use App\Http\Controllers\User\LogoutController;
use Illuminate\Support\Facades\Route;


Route::get('logout', [LogoutController::class, 'logout'])
    ->middleware(['auth', 'auth.session'])
    ->name('logout');
