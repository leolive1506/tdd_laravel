<?php

use App\Http\Controllers\RegisterController;
use App\Mail\Invitation;
use App\Models\Invites;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {});

Route::post('invite', function () {
    Mail::to(request()->email)->send(new Invitation());
    Invites::create(['email' => request()->email]);
});


Route::post('register', RegisterController::class)->name('register');
