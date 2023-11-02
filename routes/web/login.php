<?php

use App\Http\Controllers\User\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'guest', 'auth.session'])->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login');
});
