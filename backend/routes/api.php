<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    AuthController,
    ProductController,
    CategoryController,
    BrandController,
    FavoriteController
};

use Laravel\Fortify\Http\Controllers\{
    PasswordResetLinkController,
    NewPasswordController,
    EmailVerificationNotificationController,
    VerifyEmailController,
    ConfirmablePasswordController,
    TwoFactorAuthenticatedSessionController
};

// 🔓 Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
Route::post('/reset-password', [NewPasswordController::class, 'store']);

// 🔐 Rutas protegidas con JWT
Route::middleware('auth:api')->group(function () {
    // 🧑 Usuario
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // 🛡️ Fortify extra
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store']);
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify');
    Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);

    // 📦 Recursos API
    Route::apiResource('/products', ProductController::class)->except(['create', 'edit']);
    Route::apiResource('/categories', CategoryController::class)->except(['show', 'create', 'edit']);
    Route::apiResource('/brands', BrandController::class)->except(['show', 'create', 'edit']);

    // ⭐ Favoritos
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);
});
