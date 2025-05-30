<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    AuthController,
    UserController,
    RoleController,
    AddressController,
    ProductController,
    CategoryController,
    BrandController,
    DiscountController,
    FavoriteController,
    CartController,
    OrderController,
    InvoiceController,
    BudgetController,
    RepairController,
    ContactController,
    NotificationController,
    AdminStatsController,
    PaypalController
};

use App\Http\Controllers\API\Auth\VerifyEmailController;
use Laravel\Fortify\Http\Controllers\{
    PasswordResetLinkController,
    NewPasswordController,
    EmailVerificationNotificationController,
    ConfirmablePasswordController,
    TwoFactorAuthenticatedSessionController
};

//
// ───────────────────────────────────────────────
// 🔓 RUTAS PÚBLICAS (Sin autenticación)
// ───────────────────────────────────────────────
//

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
Route::post('/reset-password', [NewPasswordController::class, 'store']);

// Verificación de correo electrónico (Fortify)
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store']);
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware('signed')->name('verification.verify');
Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);

// Roles disponibles (sin auth)
Route::get('/roles', [RoleController::class, 'index']);

// ⚠️ Ruta externa necesaria para redirección PayPal (sin auth)
Route::get('/paypal/success', [PayPalController::class, 'captureOrder']);

//Contact us
Route::post('/contact', [ContactController::class, 'send']);
//
// ───────────────────────────────────────────────
// 🔐 RUTAS PROTEGIDAS (Requieren JWT)
// ───────────────────────────────────────────────
//
Route::middleware('auth:api')->group(function () {

    // 🧑 Perfil
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/profile', [UserController::class, 'update']);
    Route::put('/profile-information', [UserController::class, 'updateProfileInformation']);
    Route::post('/user/confirm-password', [UserController::class, 'confirmPassword']);

    // 👤 Administración de usuarios
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'updateUser']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // 📦 Productos y Garantías
    Route::apiResource('/products', ProductController::class)->except(['create', 'edit']);
    Route::get('/products/user', [ProductController::class, 'productosConGarantia']);

    // 📂 Categorías y Marcas
    Route::apiResource('/categories', CategoryController::class)->except(['show', 'create', 'edit']);
    Route::apiResource('/brands', BrandController::class)->except(['show', 'create', 'edit']);

    // ⭐ Favoritos
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);

    // 🛒 Carrito
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::put('/cart/{id}', [CartController::class, 'update']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
    Route::post('/cart/clear', [CartController::class, 'clear']);

    // 🧾 Órdenes
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);

    // 🧾 Invoices
    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::post('/invoices', [InvoiceController::class, 'store']);
    Route::get('/invoices/{id}', [InvoiceController::class, 'show']);
    Route::get('/invoices/{id}/download', [InvoiceController::class, 'download']);
    Route::get('/invoices/{id}/generate-pdf', [InvoiceController::class, 'generatePdf']);


    // 📍 Dirección
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::put('/addresses/{id}', [AddressController::class, 'update']);
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);

    // 🧰 Reparaciones
    Route::apiResource('repairs', RepairController::class);

    // 🧾 Presupuestos
    Route::post('/budgets', [BudgetController::class, 'store']);
    Route::get('/budgets', [BudgetController::class, 'index']);
    Route::get('/budgets/{id}', [BudgetController::class, 'show']);
    Route::put('/budgets/{id}', [BudgetController::class, 'update']);
    Route::post('/budgets/{id}/reply', [BudgetController::class, 'reply']);

    // 💸 Descuentos
    Route::get('/discounts', [DiscountController::class, 'index']);
    Route::post('/discounts', [DiscountController::class, 'store']);
    Route::put('/discounts/{id}', [DiscountController::class, 'update']);
    Route::delete('/discounts/{id}', [DiscountController::class, 'destroy']);

    // 🔔 Notificaciones
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread', [NotificationController::class, 'unread']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead']);
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markRead']);

    // 📊 Estadísticas de administrador
    Route::get('/admin/stats', [AdminStatsController::class, 'index']);

    // 💰 Pasarela de Pago (PayPal)
    Route::post('/paypal/create-payment', [PaypalController::class, 'create']);
    Route::post('/paypal/capture-payment', [PaypalController::class, 'capture']);
    Route::post('/paypal/create-order', [PaypalController::class, 'createOrder']);



});
