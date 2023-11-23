<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderDetailController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('forgot-password', function () {
        return view('pages.auth.forgot');
    });
});

Route::middleware('auth')->group(function(){
    Route::get('/', function () {
        $title = 'Dashboard';
        return view('pages.dashboard.dashboard', compact('title'));
    });
    Route::resource('purchase-order', PurchaseOrderController::class)->except(['create']);
    Route::put('purchase-order/{purchase_order}/approve', [PurchaseOrderController::class, 'approve'])->name('purchase-order.approve');
    Route::get('purchase-order/{purchase_order}/print', [PurchaseOrderController::class, 'print'])->name('purchase-order.print');
    Route::resource('stock', StockController::class);
    Route::resource('item', ItemController::class);
    Route::post('item/get/{id}', [ItemController::class, 'get'])->name('item.get');
    Route::post('item/all', [ItemController::class, 'all'])->name('item.all');
    Route::resource('category', CategoryController::class)->except('show');
    Route::resource('unit', UnitController::class)->except('show');
    Route::resource('user', UserController::class);
    Route::post('purchase-order/store', [PurchaseOrderDetailController::class, 'store'])->name('purchase-order-detail.store');
    Route::post('purchase-order/delete', [PurchaseOrderDetailController::class, 'delete'])->name('purchase-order-detail.delete');
    Route::post('purchase-order/get', [PurchaseOrderDetailController::class, 'get_by_po'])->name('purchase-order-detail.get_by_po');

    Route::get('/change-password', [AuthController::class, 'change_password'])->name('change_password');
    Route::post('/change-password', [AuthController::class, 'do_change_password'])->name('do_change_password');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::get('item', function(){
    //     return view('pages.item.index');
    // });
// Route::get('item/create', function(){
    //     return view('pages.item.create');
// });
// Route::get('item/1/edit', function(){
//     return view('pages.unit.edit');
// });
// Route::get('item/1', function(){
//     return view('pages.item.read');
// });

