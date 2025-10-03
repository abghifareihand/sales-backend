<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\Cabang\CabangDashboardController;
use App\Http\Controllers\Web\Cabang\CabangStockController;
use App\Http\Controllers\Web\Cabang\CabangTransactionController;
use App\Http\Controllers\Web\Cabang\CabangUserController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\Owner\OwnerBranchController;
use App\Http\Controllers\Web\Owner\OwnerDashboardController;
use App\Http\Controllers\Web\Owner\OwnerProductController;
use App\Http\Controllers\Web\Owner\OwnerStockController;
use App\Http\Controllers\Web\Owner\OwnerTransactionController;
use App\Http\Controllers\Web\Owner\OwnerTransactionEditController;
use App\Http\Controllers\Web\Owner\OwnerUserController;
use App\Http\Controllers\Web\Pusat\PusatBranchController;
use App\Http\Controllers\Web\Pusat\PusatDashboardController;
use App\Http\Controllers\Web\Pusat\PusatProductController;
use App\Http\Controllers\Web\Pusat\PusatStockController;
use App\Http\Controllers\Web\Pusat\PusatTransactionController;
use App\Http\Controllers\Web\Pusat\PusatTransactionEditController;
use App\Http\Controllers\Web\Pusat\PusatUserController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// Route Tanpa Login
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Route Harus Login
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markRead'])->name('distributions.markRead');
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index')
        ->middleware([RoleMiddleware::class . ':owner,pusat']);


    // ================= OWNER =================
    Route::prefix('owner')->middleware([RoleMiddleware::class . ':owner'])->group(function() {
        Route::get('dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard.index');

        // Product
        Route::get('product', [OwnerProductController::class, 'index'])->name('owner.product.index');
        Route::get('product/create', [OwnerProductController::class, 'create'])->name('owner.product.create');
        Route::post('product', [OwnerProductController::class, 'store'])->name('owner.product.store');
        Route::get('product/{product}/edit', [OwnerProductController::class, 'edit'])->name('owner.product.edit');
        Route::put('product/{product}', [OwnerProductController::class, 'update'])->name('owner.product.update');
        Route::get('product/{product}', [OwnerProductController::class, 'show'])->name('owner.product.show');
        Route::delete('product/{product}', [OwnerProductController::class, 'destroy'])->name('owner.product.destroy');

        // Branch Cabang
        Route::get('branch', [OwnerBranchController::class, 'index'])->name('owner.branch.index');
        Route::get('branch/create', [OwnerBranchController::class, 'create'])->name('owner.branch.create');
        Route::post('branch', [OwnerBranchController::class, 'store'])->name('owner.branch.store');
        Route::get('branch/{branch}/edit', [OwnerBranchController::class, 'edit'])->name('owner.branch.edit');
        Route::put('branch/{branch}', [OwnerBranchController::class, 'update'])->name('owner.branch.update');
        Route::get('branch/{branch}', [OwnerBranchController::class, 'show'])->name('owner.branch.show');

        // Stock Pusat
        Route::get('stock/pusat', [OwnerStockController::class, 'stockPusat'])->name('owner.stock.pusat.index');
        Route::get('stock/pusat/create', [OwnerStockController::class, 'createStockPusat'])->name('owner.stock.pusat.create');
        Route::post('stock/pusat', [OwnerStockController::class, 'storeStockPusat'])->name('owner.stock.pusat.store');
        Route::get('stock/{stock}/edit', [OwnerStockController::class, 'editStockPusat'])->name('owner.stock.pusat.edit');
        Route::put('stock/{stock}', [OwnerStockController::class, 'updateStockPusat'])->name('owner.stock.pusat.update');
        Route::get('stock/pusat/{stock}/distribution', [OwnerStockController::class, 'distributionToCabangForm'])->name('owner.stock.pusat.distribution.form');
        Route::post('stock/pusat/distribution', [OwnerStockController::class, 'distributionToCabang'])->name('owner.stock.pusat.distribution');

        // Stock Cabang
        Route::get('stock/cabang', [OwnerStockController::class, 'stockCabang'])->name('owner.stock.cabang.index');
        Route::get('stock/cabang/{stock}/distribution', [OwnerStockController::class, 'distributionToSalesForm'])->name('owner.stock.cabang.distribution.form');
        Route::post('stock/cabang/distribution', [OwnerStockController::class, 'distributionToSales'])->name('owner.stock.cabang.distribution');

        // Stock Sales
        Route::get('stock/sales', [OwnerStockController::class, 'stockSales'])->name('owner.stock.sales.index');


        // User Pusat
        Route::get('user/pusat', [OwnerUserController::class, 'indexPusat'])->name('owner.user.pusat.index');
        Route::get('user/pusat/create', [OwnerUserController::class, 'createPusat'])->name('owner.user.pusat.create');
        Route::post('user/pusat/store', [OwnerUserController::class, 'storePusat'])->name('owner.user.pusat.store');
        Route::get('user/pusat/{user}/edit', [OwnerUserController::class, 'editPusat'])->name('owner.user.pusat.edit');
        Route::put('user/pusat/{user}', [OwnerUserController::class, 'updatePusat'])->name('owner.user.pusat.update');
        Route::delete('user/pusat/{user}', [OwnerUserController::class, 'destroyPusat'])->name('owner.user.pusat.destroy');

        // User Cabang
        Route::get('user/cabang', [OwnerUserController::class, 'indexCabang'])->name('owner.user.cabang.index');
        Route::get('user/cabang/create', [OwnerUserController::class, 'createcabang'])->name('owner.user.cabang.create');
        Route::post('user/cabang/store', [OwnerUserController::class, 'storecabang'])->name('owner.user.cabang.store');
        Route::get('user/cabang/{user}/edit', [OwnerUserController::class, 'editcabang'])->name('owner.user.cabang.edit');
        Route::put('user/cabang/{user}', [OwnerUserController::class, 'updatecabang'])->name('owner.user.cabang.update');
        Route::delete('user/cabang/{user}', [OwnerUserController::class, 'destroycabang'])->name('owner.user.cabang.destroy');

        // User Sales
        Route::get('user/sales', [OwnerUserController::class, 'indexSales'])->name('owner.user.sales.index');
        Route::get('user/sales/create', [OwnerUserController::class, 'createsales'])->name('owner.user.sales.create');
        Route::post('user/sales/store', [OwnerUserController::class, 'storesales'])->name('owner.user.sales.store');
        Route::get('user/sales/{user}/edit', [OwnerUserController::class, 'editsales'])->name('owner.user.sales.edit');
        Route::put('user/sales/{user}', [OwnerUserController::class, 'updatesales'])->name('owner.user.sales.update');
        Route::delete('user/sales/{user}', [OwnerUserController::class, 'destroysales'])->name('owner.user.sales.destroy');

        // Transaction Edit Sales
        Route::get('transaction/edit', [OwnerTransactionEditController::class, 'index'])->name('owner.transaction.index.edit');
        Route::get('transaction/edit/{transaction}', [OwnerTransactionEditController::class, 'show'])->name('owner.transaction.show.edit');
        Route::post('transaction/edit/{edit}/approve', [OwnerTransactionEditController::class, 'approveEdit'])->name('owner.transaction.approve.edit');
        Route::post('transaction/edit/{edit}/reject', [OwnerTransactionEditController::class, 'rejectEdit'])->name('owner.transaction.reject.edit');

        // Transaction Sales
        Route::get('transaction', [OwnerTransactionController::class, 'index'])->name('owner.transaction.index');
        Route::get('transaction/{transaction}', [OwnerTransactionController::class, 'show'])->name('owner.transaction.show');
    });

    // ================= PUSAT =================
    Route::prefix('pusat')->middleware([RoleMiddleware::class . ':pusat'])->group(function() {
        Route::get('dashboard', [PusatDashboardController::class, 'index'])->name('pusat.dashboard.index');

        // Product
        Route::get('product', [PusatProductController::class, 'index'])->name('pusat.product.index');
        Route::get('product/create', [PusatProductController::class, 'create'])->name('pusat.product.create');
        Route::post('product', [PusatProductController::class, 'store'])->name('pusat.product.store');
        Route::get('product/{product}/edit', [PusatProductController::class, 'edit'])->name('pusat.product.edit');
        Route::put('product/{product}', [PusatProductController::class, 'update'])->name('pusat.product.update');
        Route::get('product/{product}', [PusatProductController::class, 'show'])->name('pusat.product.show');
        Route::delete('product/{product}', [PusatProductController::class, 'destroy'])->name('pusat.product.destroy');

        // Stock Pusat
        Route::get('stock/pusat', [PusatStockController::class, 'stockPusat'])->name('pusat.stock.pusat.index');
        Route::get('stock/pusat/create', [PusatStockController::class, 'createStockPusat'])->name('pusat.stock.pusat.create');
        Route::post('stock/pusat', [PusatStockController::class, 'storeStockPusat'])->name('pusat.stock.pusat.store');
        Route::get('stock/{stock}/edit', [PusatStockController::class, 'editStockPusat'])->name('pusat.stock.pusat.edit');
        Route::put('stock/{stock}', [PusatStockController::class, 'updateStockPusat'])->name('pusat.stock.pusat.update');
        Route::get('stock/pusat/{stock}/distribution', [PusatStockController::class, 'distributionForm'])->name('pusat.stock.pusat.distribution.form');
        Route::post('stock/pusat/distribution', [PusatStockController::class, 'distributionToCabang'])->name('pusat.stock.pusat.distribution');

        // Stock Cabang
        Route::get('stock/cabang', [PusatStockController::class, 'stockCabang'])->name('pusat.stock.cabang.index');

        // Stock Cabang
        Route::get('stock/sales', [PusatStockController::class, 'stockSales'])->name('pusat.stock.sales.index');


        // Branch
        Route::get('branch', [PusatBranchController::class, 'index'])->name('pusat.branch.index');
        Route::get('branch/create', [PusatBranchController::class, 'create'])->name('pusat.branch.create');
        Route::post('branch', [PusatBranchController::class, 'store'])->name('pusat.branch.store');
        Route::get('branch/{branch}/edit', [PusatBranchController::class, 'edit'])->name('pusat.branch.edit');
        Route::put('branch/{branch}', [PusatBranchController::class, 'update'])->name('pusat.branch.update');
        Route::get('branch/{branch}', [PusatBranchController::class, 'show'])->name('pusat.branch.show');

        // User cabang
        Route::get('user', [PusatUserController::class, 'index'])->name('pusat.user.index');
        Route::get('user/create', [PusatUserController::class, 'create'])->name('pusat.user.create');
        Route::post('user', [PusatUserController::class, 'store'])->name('pusat.user.store');
        Route::get('user/{user}/edit', [PusatUserController::class, 'edit'])->name('pusat.user.edit');
        Route::put('user/{user}', [PusatUserController::class, 'update'])->name('pusat.user.update');
        Route::delete('user/{user}', [PusatUserController::class, 'destroy'])->name('pusat.user.destroy');

        // Transaction Edit Sales
        Route::get('transaction/edit', [PusatTransactionEditController::class, 'index'])->name('pusat.transaction.index.edit');
        Route::get('transaction/edit/{transaction}', [PusatTransactionEditController::class, 'show'])->name('pusat.transaction.show.edit');
        Route::post('transaction/edit/{edit}/approve', [PusatTransactionEditController::class, 'approveEdit'])->name('pusat.transaction.approve.edit');
        Route::post('transaction/edit/{edit}/reject', [PusatTransactionEditController::class, 'rejectEdit'])->name('pusat.transaction.reject.edit');

        // Transaction Sales
        Route::get('transaction', [PusatTransactionController::class, 'index'])->name('pusat.transaction.index');
        Route::get('transaction/{transaction}', [PusatTransactionController::class, 'show'])->name('pusat.transaction.show');
    });

    // ================= cabang =================
    Route::prefix('cabang')->middleware([RoleMiddleware::class . ':cabang'])->group(function() {
        Route::get('dashboard', [CabangDashboardController::class, 'index'])->name('cabang.dashboard.index');

        // Stock
        Route::get('stock/cabang', [CabangStockController::class, 'stockCabang'])->name('cabang.stock.cabang.index');
        Route::get('stock/sales', [CabangStockController::class, 'stockSales'])->name('cabang.stock.sales.index');

        // Distribution
        Route::get('stock/{stock}/distribution', [CabangStockController::class, 'distributionForm'])->name('cabang.stock.cabang.distribution.form');
        Route::post('stock/distribution', [CabangStockController::class, 'distributionToSales'])->name('cabang.stock.cabang.distribution');

        // User sales
        Route::get('user', [CabangUserController::class, 'index'])->name('cabang.user.index');
        Route::get('user/create', [CabangUserController::class, 'create'])->name('cabang.user.create');
        Route::post('user', [CabangUserController::class, 'store'])->name('cabang.user.store');
        Route::get('user/{user}/edit', [CabangUserController::class, 'edit'])->name('cabang.user.edit');
        Route::put('user/{user}', [CabangUserController::class, 'update'])->name('cabang.user.update');

        // Return
        Route::get('stock/{stock}/return', [CabangStockController::class, 'returnForm'])->name('cabang.stock.cabang.return.form');
        Route::post('stock/return', [CabangStockController::class, 'returnToPusat'])->name('cabang.stock.cabang.return');

        // Transaction Sales dari cabang ini
        Route::get('transaction', [CabangTransactionController::class, 'index'])->name('cabang.transaction.index');
        Route::get('transaction/{transaction}', [CabangTransactionController::class, 'show'])->name('cabang.transaction.show');
        Route::get('transaction/{transaction}/edit', [CabangTransactionController::class, 'editSubmitPrice'])->name('cabang.transaction.edit');
        Route::post('transaction/{transaction}', [CabangTransactionController::class, 'updateSubmitPrice'])->name('cabang.transaction.update');

    });
});
