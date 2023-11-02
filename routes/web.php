<?php

use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require_once base_path() . '/routes/web/login.php';
require_once base_path() . '/routes/web/register.php';
require_once base_path() . '/routes/web/logout.php';

Route::redirect('/', 'login')
    ->middleware(['web', 'guest', 'auth.session']);

Route::get('/', [HomeController::class, 'index'])
    ->middleware(['auth', 'auth.session'])
    ->name('home');

