<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WarehouseController;
use App\Http\Middleware\EnsureHapAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('web')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::middleware([EnsureHapAdmin::class])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('orders/{order}/assign-location', [OrderController::class, 'assignLocation'])->name('orders.assign-location');
        Route::post('orders/{order}/dispatch', [OrderController::class, 'dispatch'])->name('orders.dispatch');

        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');

        Route::get('reports/sales-summary', [ReportController::class, 'salesSummary'])->name('reports.sales-summary');
        Route::get('reports/order-status', [ReportController::class, 'orderStatus'])->name('reports.order-status');
        Route::get('reports/inventory-summary', [ReportController::class, 'inventorySummary'])->name('reports.inventory-summary');

        Route::get('warehouse/locations', [WarehouseController::class, 'locations'])->name('warehouse.locations');
        Route::match(['get', 'post'], 'warehouse/goods-inward', [WarehouseController::class, 'goodsInward'])->name('warehouse.goods-inward');
        Route::get('warehouse/picking-lists', [WarehouseController::class, 'pickingLists'])->name('warehouse.picking-lists');
        Route::post('warehouse/picking-lists', [WarehouseController::class, 'createPickingList'])->name('warehouse.picking-lists.create');

        Route::get('pos/eod-summary', [PosController::class, 'eodSummary'])->name('pos.eod-summary');
    });
});
