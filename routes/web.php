<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/quiz');
});

// Halaman Kuis Publik
Route::get('/quiz', [\App\Http\Controllers\QuizController::class, 'index'])->name('quiz.index');
Route::post('/quiz/register', [\App\Http\Controllers\QuizController::class, 'register'])->name('quiz.register');
Route::get('/quiz/play', [\App\Http\Controllers\QuizController::class, 'play'])->name('quiz.play');
Route::post('/quiz/finish', [\App\Http\Controllers\QuizController::class, 'finish'])->name('quiz.finish');

Auth::routes([
    'register' => false,
    'reset'    => false
]);
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    // Custom Routes for Questions
    Route::post('/questions/import', [\App\Http\Controllers\QuestionController::class, 'import'])->name('questions.import');
    Route::get('/questions/template', [\App\Http\Controllers\QuestionController::class, 'downloadTemplate'])->name('questions.template');
    
    Route::resource('questions', \App\Http\Controllers\QuestionController::class);
    Route::resource('players', \App\Http\Controllers\PlayerController::class)->only(['index', 'destroy']);
    Route::resource('game_sessions', \App\Http\Controllers\GameSessionController::class)->only(['index', 'destroy']);

    Route::resource('sessions', \App\Http\Controllers\SessionController::class)->only(['index', 'destroy']);
    Route::patch('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
