<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GAuth\GoogleAuthController;

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


Route::get('/0auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('gauth');
Route::get('/0auth/google/callback', [GoogleAuthController::class, 'callback'])->name('gauthCallback');
