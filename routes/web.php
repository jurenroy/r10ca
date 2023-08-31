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

// Authentication
Route::get('/login', [AuthManager::class, 'login'])->name('login');


// End of Authentication

// Registration
Route::get('/new-user', [AuthManager::class, 'registration'])->name('registration');

// End of Registration