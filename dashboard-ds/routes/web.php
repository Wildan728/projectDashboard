<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\SbsController;
use App\Http\Controllers\SbtController;
use App\Http\Controllers\SbuController;
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
    return redirect('/login');
});

// Hapus salah satu /login, cukup satu aja
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('session.auth')->group(function () {
    // Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/sbs', [SbsController::class, 'index']);
    Route::get('/sbt', [SbtController::class, 'index']);
    Route::get('/sbu', [SbuController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);
});