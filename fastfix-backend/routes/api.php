<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;

// ⚠️ Ya NO usas estas 3 de Fortify:
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// ✅ Rutas protegidas con JWT:
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Fortify que requiere autenticación:
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store']);
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify');
    Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);
});

// ✅ Fortify para recuperación de contraseña (no requieren auth)
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
Route::post('/reset-password', [NewPasswordController::class, 'store']);
