<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    GuaranteeController,
    OrderController,
    AuthController,
    ImageController,
    InvoiceController,
    ProductController,
    AddressController,
    DiscountController,
    CategoryController,
    BrandController,
    VoucherController,
    FavoriteController,
    CartController,
    BudgetController,
    UserController
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
Route::post('/budgets', [BudgetController::class, 'store']); // pública

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

    // 🛒 Carrito
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
    Route::post('/cart/clear', [CartController::class, 'clear']);

    // 🛒 Ordenes
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    // 🛒 Garantias
    Route::get('/guarantees', [GuaranteeController::class, 'index']);
    Route::post('/guarantees', [GuaranteeController::class, 'store']);
    Route::delete('/guarantees/{id}', [GuaranteeController::class, 'destroy']);

    // Budgets
    Route::get('/budgets', [BudgetController::class, 'index']); // admin
    Route::get('/budgets/{id}', [BudgetController::class, 'show']); //admin

    // Usuario
    Route::put('/profile', [UserController::class, 'update']); // usuario
    Route::get('/users', [UserController::class, 'index']);    // admin
    Route::get('/users/{id}', [UserController::class, 'show']); // admin
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // admin

    // Descuentos
    Route::get('/discounts', [DiscountController::class, 'index']);
    Route::post('/discounts', [DiscountController::class, 'store']);
    Route::put('/discounts/{id}', [DiscountController::class, 'update']);
    Route::delete('/discounts/{id}', [DiscountController::class, 'destroy']);

    // Vouchers
    Route::get('/vouchers', [VoucherController::class, 'index']);
    Route::post('/vouchers', [VoucherController::class, 'store']);
    Route::put('/vouchers/{id}', [VoucherController::class, 'update']);
    Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy']);
    Route::post('/vouchers/validate', [VoucherController::class, 'validateCode']); // uso desde frontend

    // Imagen 
    Route::get('/products/{productId}/images', [ImageController::class, 'index']);
    Route::post('/images', [ImageController::class, 'store']);
    Route::delete('/images/{id}', [ImageController::class, 'destroy']);

    // Invoices
    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::post('/invoices', [InvoiceController::class, 'store']);
    Route::get('/invoices/{id}', [InvoiceController::class, 'show']);
    Route::get('/invoices/{id}/download', [InvoiceController::class, 'download']); // futuro

    // Address
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::put('/addresses/{id}', [AddressController::class, 'update']);
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);

});
