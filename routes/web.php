<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
<<<<<<< HEAD
=======
use App\Http\Controllers\GAuth\GoogleAuthController;
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
use App\Http\Controllers\GAuth\GoogleAuthController;
>>>>>>> 48871c4 (REMIS update on 12-07-2023)

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
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)


Route::get('/0auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('gauth');
Route::get('/0auth/google/callback', [GoogleAuthController::class, 'callback'])->name('gauthCallback');
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
