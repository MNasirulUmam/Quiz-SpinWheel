<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

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
});


