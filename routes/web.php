<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\HobbyController;
use App\Http\Controllers\FormController;

Route::get('/forms', [FormController::class, 'index'])->name('forms.index');
Route ::get('/forms/{id}/open', [FormController::class, 'show'])->name('forms.show');
Route::get('/forms/{id}/edit', [FormController::class, 'edit'])->name('forms.edit'); 


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
        return view('form');
    })->name('form');
    Route::get('/test', function () {
        return view('test');
    })->name('test');
    // Application List page
    Route::get('/application-list', function () {
        return view('application_list');
    })->name('application.list');
});

Route::get('/nationalities', [NationalityController::class, 'index'])->name('nationalities.index');
Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');
Route::get('/hobbies', [HobbyController::class, 'index'])->name('hobbies.index');
Route::post('/forms', [FormController::class, 'store'])->name('forms.store');
Route::get('/forms/{id}/download-pdf', [FormController::class, 'downloadPdf'])->name('forms.downloadPdf');
