<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthenticateController;
use App\Http\Controllers\Api\Auth\PasswordRecoveryController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;


Route::get('/login' ,function(){
    return response()->json(["message" => "login Page"]);
});
Route::get('/reset-password/{token}' ,function(){
    return response()->json(["message" => "password-reset-page "]);
})->name('password.reset');



Route::group(['middleware' => ['guest']],function (){
    Route::post('/login', [AuthenticateController::class, 'login'])->name('login');
    Route::post('/register', [AuthenticateController::class, 'register'])->name('register');


    Route::post('/forgot-password', [PasswordRecoveryController::class, 'sendResetLink']);
    Route::post('/reset-password', [PasswordRecoveryController::class, 'resetPassword']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthenticateController::class, 'user']);
    Route::post('/logout', [AuthenticateController::class, 'logout']);
    Route::post('/verify-email', [EmailVerificationController::class, 'sendVerificationLink']);
});

Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verifyEmail'])->name('verification.verify');

