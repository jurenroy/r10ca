<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppearancesLogsController;

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
    return view('ca-form');
});

Route::post('/save-log', [AppearancesLogsController::class, 'saveLog'])->name('save.log');
Route::get('/login', function() {
    return view('login');
})->name('login');