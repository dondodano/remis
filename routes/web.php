<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GAuth\GoogleAuthController;
use App\Filament\Resources\ProjectResource\Pages\EvaluateProject;

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

/**
 * Google Log in
 */
Route::get('/0auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('gauth');
Route::get('/0auth/google/callback', [GoogleAuthController::class, 'callback'])->name('gauthCallback');

Route::prefix('admin')->group(function(){
    /**
     * Project Pages
     */
    Route::get('/projects/{record}/evaluate', EvaluateProject::class)->name('project.evaluate');
});
