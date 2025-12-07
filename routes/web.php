<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminAuctionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\SupportController;

/*
|--------------------------------------------------------------------------
| Public home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Chỉ hiển thị sản phẩm đang active và chưa kết thúc đấu giá
    $products = \App\Models\Product::with('images')
        ->where('status', 'active')
        ->where('end_time', '>', now())
        ->orderBy('end_time', 'desc')
        ->get();

    $categories = \App\Models\Product::distinct()
        ->pluck('category')
        ->filter()
        ->values();

    return view('home', compact('products', 'categories'));
});

/*
|--------------------------------------------------------------------------
| Product routes
|--------------------------------------------------------------------------
*/
// Filter sản phẩm - Phải đặt TRƯỚC Route::resource để tránh conflict
Route::get('/products/featured', [ProductController::class, 'featured'])->name('products.featured');
Route::get('/products/active', [ProductController::class, 'active'])->name('products.active');
Route::get('/products/ending-soon', [ProductController::class, 'endingSoon'])->name('products.endingSoon');

// Resource routes (index, show, create, store, edit, update, destroy)
Route::resource('products', ProductController::class);

// Đấu giá, giao dịch (chỉ còn route xóa ảnh ở ngoài, phần còn lại đưa vào group auth)
Route::delete(
    '/product-images/{id}',
    [ProductController::class, 'deleteImage']
)->name('product-images.destroy');

/*
|--------------------------------------------------------------------------
| User Auth
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Admin Auth + Admin area
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // ---- LOGIN / LOGOUT ADMIN (KHÔNG middleware) ----
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // ---- CÁC ROUTE CẦN ĐĂNG NHẬP ADMIN ----
    Route::middleware(['auth:admin'])->group(function () {

        // Dashboard
        Route::get('/', function () {
            return redirect()->route('admin.auctions');
        })->name('dashboard');

        // Phiên đấu giá
        Route::get('/auctions', [AdminAuctionController::class, 'index'])->name('auctions');
        Route::get('/auctions/{id}', [AdminAuctionController::class, 'show'])->name('auctions.show');

        // Hộp thư hỗ trợ (inbox)
        Route::post(
            '/inbox/{conversation}/pin',
            [\App\Http\Controllers\Admin\InboxController::class, 'pin']
        )->name('inbox.pin');

        Route::delete(
            '/inbox/{conversation}/delete',
            [\App\Http\Controllers\Admin\InboxController::class, 'delete']
        )->name('inbox.delete');

        Route::get(
            '/inbox',
            [\App\Http\Controllers\Admin\InboxController::class, 'index']
        )->name('inbox');

        Route::get(
            '/inbox/{conversation}',
            [\App\Http\Controllers\Admin\InboxController::class, 'show']
        )->name('inbox.show');

        Route::post(
            '/inbox/{conversation}/send',
            [\App\Http\Controllers\Admin\InboxController::class, 'send']
        )->name('inbox.send');

        // Quản lý sản phẩm
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::post('/products/{id}/approve', [AdminProductController::class, 'approve'])->name('products.approve');

        // Profile admin
        Route::get('/profile', [AdminProfileController::class, 'showProfile'])->name('profile');
        Route::post('/change-password', [AdminProfileController::class, 'changePassword'])->name('changePassword');
    });
});

/*
|--------------------------------------------------------------------------
| Routes cần login (user thường)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Hỗ trợ
    Route::get('/support/messages', [SupportController::class, 'messages']);
    Route::post('/support/send', [SupportController::class, 'sendAjax']);

    // Hồ sơ user
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');

    // Yêu thích & sản phẩm của tôi
    Route::post('/favorite', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::get('/favorites', [FavoriteController::class, 'list'])->name('favorites.index');
    Route::delete('/favorite', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

    // Sản phẩm của tôi
    Route::get('/my-products', [ProductController::class, 'myProducts'])
        ->name('my-products.index');

    // 🔹 Đấu giá & giao dịch (bắt buộc đăng nhập)
    Route::get('/bids', [BidController::class, 'index'])->name('bids.index');

    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])
        ->name('transactions.show');

    Route::post('/products/{id}/bid', [ProductController::class, 'bid'])
        ->name('products.bid');
    Route::post('/products/{id}/extend', [ProductController::class, 'extend'])
        ->name('products.extend');
    Route::post('/products/{id}/confirm-sold', [ProductController::class, 'confirmSold'])
        ->name('products.confirmSold');
});

/*
|--------------------------------------------------------------------------
| Route dashboard admin (fallback /admin)
|--------------------------------------------------------------------------
*/
Route::get('/admin', function () {
    if (!auth('admin')->check()) {
        return redirect('/admin/login');
    }
    return redirect()->route('admin.auctions');
});
