<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SpecificationController;
use App\Http\Controllers\SupplierController;
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
    return view('welcome');
});

Route::get('/autocomplete', [MainController::class, 'autocomplete']);

Route::get('/report/sales/by-category', [ReportController::class, 'salesByCategory'])->name('report.salesByCategory');
Route::get('/report/sales/by-manufacturer', [ReportController::class, 'salesByManufacturer'])->name('report.salesByManufacturer');
Route::get('/report/sales/by-period', [ReportController::class, 'salesByPeriod'])->name('report.salesByPeriod');
Route::get('/report/inventory', [ReportController::class, 'inventory'])->name('report.inventory');
Route::get('/report/customer-orders', [ReportController::class, 'customerOrders'])->name('report.customerOrders');
Route::get('/report/supplies', [ReportController::class, 'supplies'])->name('report.supplies');
Route::get('/report/tbr', [ReportController::class, 'tbr'])->name('report.tbr');
Route::get('/report/profit', [ReportController::class, 'profit'])->name('report.profit');

Route::resource('category', CategoryController::class);

Route::resource('specification', SpecificationController::class);

Route::resource('supplier', SupplierController::class);

Route::resource('invoice', InvoiceController::class);

Route::resource('product', ProductController::class);

Route::resource('manufacturer', ManufacturerController::class);

Route::resource('order', OrderController::class);

Route::resource('payment', PaymentController::class);

Route::resource('client', ClientController::class);

//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
