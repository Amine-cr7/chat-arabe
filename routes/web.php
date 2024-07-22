<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
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
Route::get('/register',[RegisterController::class,'registerPage']);
Route::post('/register',[RegisterController::class,'registerAction'])->name('register');
Route::middleware('auth')->group(function () {
    Route::get('/users',[UserController::class,'index']);
    Route::get('/logout',[RegisterController::class,'logout']);
    Route::get('/chat/{receiver}',[ChatController::class,'getReceiver'])->middleware('chatAuth');
    Route::post('/chat/{receiver}',[ChatController::class,'sendMessage']);
});