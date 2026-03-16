<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', function () { return view('dashboard'); })->name('dashboard');
});

Route::get('/game2', function () {
    return view('games/game2');
})->middleware(['auth'])->name('game2');

Route::get('/game1', function () {
    return view('games/game1');
})->middleware(['auth'])->name('game1');


Route::get('/game3', function () {
    return view('games/game3');
})->middleware(['auth'])->name('game3');

Route::get('/game4', function () {
    return view('games/game4');
})->middleware(['auth'])->name('game4');