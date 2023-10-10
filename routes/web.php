<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UnitController;
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

Route::get('/', function () {
    return view('pages.dashboard.dashboard');
});
Route::get('login', function () {
    return view('pages.auth.login');
});
Route::get('forgot-password', function () {
    return view('pages.auth.forgot');
});

Route::resource('item', ItemController::class);
Route::resource('category', CategoryController::class);
Route::resource('unit', UnitController::class);
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

