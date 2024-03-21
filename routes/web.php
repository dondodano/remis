<?php

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
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


/**
 * Test
 */
Route::get('/login', function(){
    return '<a href="/admin/login">Click here to login</a>';
})->name('login');

Route::get('/test', function(){
    // return User::with(['roles' => function($withRoles){
    //     $withRoles->with(['assignment' => function($withAssignment){
    //         $withAssignment->whereNot('role_nice', 'planning officer');
    //     }]);
    // }])->get()->toArray();

    return User::whereHas('roles', function(Builder $roleQuery){
        $roleQuery->whereHas('assignment', function(Builder $assignmentsQuery){
            $assignmentsQuery->where('role_nice', 'planning officer');
        });
    })->count();
});
