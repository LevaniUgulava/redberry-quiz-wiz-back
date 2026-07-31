<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::post('/forgot-password', [PasswordResetController::class, 'forgetPassword'])->name('password.email');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::patch('/update-avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');

});

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');

Route::post('/verify-email/resend', [AuthController::class, 'resendVerify'])
    ->name('verification.resend');
