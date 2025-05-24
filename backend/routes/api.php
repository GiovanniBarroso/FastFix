<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    GuaranteeController,
    OrderController,
    AuthController,
    RepairController,
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
    UserController,
    RoleController,
    AdminStatsController,
    NotificationController,
};

use Laravel\Fortify\Http\Controllers\{
    PasswordResetLinkController,
    NewPasswordController,
    EmailVerificationNotificationController,
    ConfirmablePasswordController,
    TwoFactorAuthenticatedSessionController
};

use App\Http\Controllers\API\Auth\VerifyEmailController;


// 🛡️ Rutas de Fortify
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store']);
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware('signed')
    ->name('verification.verify');

// Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store']);
Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);

// 🔓 Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
Route::post('/reset-password', [NewPasswordController::class, 'store']);

// 🔓 Obtener roles disponibles para formularios (sin auth)
Route::get('/roles', [RoleController::class, 'index']);

// 🔐 Rutas protegidas con JWT
Route::middleware('auth:api')->group(function () {

    // 🧑 Usuario
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/admin/stats', [AdminStatsController::class, 'index']);

    // 📦 Recursos API
    Route::apiResource('/products', ProductController::class)->except(['create', 'edit']);
    Route::apiResource('/categories', CategoryController::class)->except(['show', 'create', 'edit']);
    Route::apiResource('/brands', BrandController::class)->except(['show', 'create', 'edit']);
    Route::post('/budgets', [BudgetController::class, 'store']);

    // ⭐ Favoritos
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);

    // 🛒 Carrito
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
    Route::put('/cart/{id}', [CartController::class, 'update'])->middleware('auth:api');
    Route::post('/cart/clear', [CartController::class, 'clear']);

    // 🛒 Ordenes
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    // 🛒 Garantias
    Route::get('/guarantees', [GuaranteeController::class, 'index']);
    Route::post('/guarantees', [GuaranteeController::class, 'store']);
    Route::put('/guarantees/{id}', [GuaranteeController::class, 'update']);
    Route::delete('/guarantees/{id}', [GuaranteeController::class, 'destroy']);
    Route::get('/guarantees/by-order/{id}', [GuaranteeController::class, 'searchByOrder']);

    // Productos con garantía del usuario autenticado
    Route::get('/products/user', [ProductController::class, 'productosConGarantia']);

    // Buscar garantía por producto para el usuario autenticado
    Route::get('/guarantees/by-product/{productId}', [GuaranteeController::class, 'searchByProduct']);


    // Budgets
    Route::get('/budgets', [BudgetController::class, 'index']); // admin
    Route::get('/budgets/{id}', [BudgetController::class, 'show']); //admin
    Route::post('/budgets/{id}/reply', [BudgetController::class, 'reply']); // admin | responder por email
    Route::put('/budgets/{id}', [BudgetController::class, 'update']); // admin | actualizar estado


    // Usuario
    Route::put('/profile', [UserController::class, 'update']); // usuario
    Route::put('/profile-information', [UserController::class, 'updateProfileInformation']); // desde SPA (email, nombre)
    Route::get('/users', [UserController::class, 'index']);    // admin
    Route::get('/users/{id}', [UserController::class, 'show']); // admin
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // admin
    Route::post('/users', [UserController::class, 'store']); // Crear usuario (admin)
    Route::put('/users/{id}', [UserController::class, 'updateUser']); // Editar usuario (admin)


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

    // Repairs
    Route::apiResource('repairs', RepairController::class);

    // 🔔 Notificaciones
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread', [NotificationController::class, 'unread']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead']);
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markRead']);


    //Fortify
    Route::post('/user/confirm-password', [UserController::class, 'confirmPassword']);

});
