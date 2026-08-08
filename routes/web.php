<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/form');
});

Route::get('/form', [\App\Http\Controllers\PublicComplaintController::class, 'create'])->name('public.form');
Route::post('/form', [\App\Http\Controllers\PublicComplaintController::class, 'store'])->name('public.store');
Route::post('/cek-status', [\App\Http\Controllers\PublicComplaintController::class, 'checkStatus'])->name('public.checkStatus');

Auth::routes([
    'register' => false,
    'reset'    => false
]);
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('divisions', \App\Http\Controllers\DivisionController::class);
    Route::resource('complaint_types', \App\Http\Controllers\ComplaintTypeController::class);
    Route::resource('complaints', \App\Http\Controllers\ComplaintController::class);
    Route::resource('sessions', \App\Http\Controllers\SessionController::class)->only(['index', 'destroy']);
    Route::patch('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});


