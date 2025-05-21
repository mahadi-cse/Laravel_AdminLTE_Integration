<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\HobbyController;

// Override registration
Route::post('/register', [RegisteredUserController::class, 'store'])
     ->middleware(['guest']);

Route::get('/', function () {
    return redirect()-> route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/form', function () {
        return view('test');
    })->name('form');
    Route::get('/test', function () {
        return view('test');
    })->name('test');
});

Route::get('/nationalities', [NationalityController::class, 'index'])->name('nationalities.index');
Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');
Route::get('/hobbies', [HobbyController::class, 'index'])->name('hobbies.index');
