<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppearancesLogsController;
use App\Http\Controllers\AuthManager;

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

// Landing page
Route::get('/', function () {
    return view('ca-form');
});

Route::post('/save-log', [AppearancesLogsController::class, 'saveLog'])->name('save.log');
// End for Landing page

// Admin
Route::prefix('admin')->middleware('auth')->group(function() {
    Route::get('', function() {
        return view('dashboard');
    })->name('admin.dashboard');
    Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
    Route::post('/registration', [AuthManager::class, 'registrationProcess'])->name('registration.post');
});
// End of Admin

// Authentication
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginProcess'])->name('login.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');
// End of Authentication