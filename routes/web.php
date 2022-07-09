<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('{path}', [App\Http\Controllers\HomeController::class, 'index'])->where('path', '([A-z\d\-/_.]+)');

Route::get('/job_posting', [App\Http\Controllers\JobPostingController::class, 'index']);
Route::post('/job_posting/p', [App\Http\Controllers\JobPostingController::class, 'store']);
Route::post('/job_posting/delete/{post_id}', [App\Http\Controllers\JobPostingController::class, 'destroy']);
Route::post('/job_posting/edit/{editSelectedId}', [App\Http\Controllers\JobPostingController::class, 'edit']);

// Customer User register and logiin
// Route::get('/register', [App\Http\Controllers\UserAuthController::class, 'register']);
// Route::post('/register/validate', [App\Http\Controllers\UserAuthController::class, 'register_validate']);
// Route::get('/login', [App\Http\Controllers\UserAuthController::class, 'login']);
// Route::post('/login/validate', [App\Http\Controllers\UserAuthController::class, 'login_validate']);
// Route::get('/home', [App\Http\Controllers\UserAuthController::class, 'home']);
// Route::get('/logout', [App\Http\Controllers\UserAuthController::class, 'logout']);

