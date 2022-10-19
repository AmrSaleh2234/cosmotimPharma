<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin',[LoginController::class,'showAdminLoginForm'])->name('admin.login-view');
Route::post('/admin',[LoginController::class,'adminLogin'])->name('admin.login');

Route::get('/admin/register',[RegisterController::class,'showAdminRegisterForm'])->name('admin.register-view');
Route::post('/admin/register',[RegisterController::class,'createAdmin'])->name('admin.register');

Route::get('/admin/dashboard',function(){
    return view('admin.admin');
})->middleware('auth:admin');
Route::group(['middleware'=>'auth:admin,web'],function (){
    //start product
    Route::get('product',[\App\Http\Controllers\ProdcutController::class,'index']);
    Route::post('product/store',[\App\Http\Controllers\ProdcutController::class,'store'])->name('product.store');
    Route::post('product/edit',[\App\Http\Controllers\ProdcutController::class,'edit'])->name('product.edit');
    Route::post('product/activate',[\App\Http\Controllers\ProdcutController::class,'activate'])->name('product.activate');
    //end product
    //start inventory
    Route::get('inventory',[\App\Http\Controllers\InventoryController::class,'index'])->name('inventory.index');
    Route::post('inventory/store',[\App\Http\Controllers\InventoryController::class,'store'])->name('inventory.store');
    Route::post('inventory/edit',[\App\Http\Controllers\InventoryController::class,'edit'])->name('inventory.edit');
    Route::post('inventory/destroy',[\App\Http\Controllers\InventoryController::class,'destroy'])->name('inventory.destroy');
    //end inventory
    //start customer
    Route::get('customer',[\App\Http\Controllers\CustomerController::class,'index'])->name('customer.index');
    Route::get('customer/create',[\App\Http\Controllers\CustomerController::class,'create'])->name('customer.create');
    Route::post('customer/store',[\App\Http\Controllers\CustomerController::class,'store'])->name('customer.store');
    Route::post('customer/edit',[\App\Http\Controllers\CustomerController::class,'edit'])->name('customer.edit');
    Route::post('customer/destroy',[\App\Http\Controllers\CustomerController::class,'destroy'])->name('customer.destroy');
    //end customer
    //start customer invoice
    Route::get('customer_invoice/',[\App\Http\Controllers\InvoiceCustomerController::class,'index'])->name('invoice_customer.index');
    Route::get('customer_invoice/details/{invoice}',[\App\Http\Controllers\InvoiceCustomerController::class,'orderDetails'])->name('invoice_customer.orderDetails');
    Route::get('customer_invoice/{account}',[\App\Http\Controllers\InvoiceCustomerController::class,'create'])->name('invoice_customer.create');
    Route::post('customer_invoice/{account}',[\App\Http\Controllers\InvoiceCustomerController::class,'store'])->name('invoice_customer.store');
    Route::get('customer_invoice/edit/{invoice}',[\App\Http\Controllers\InvoiceCustomerController::class,'edit'])->name('invoice_customer.edit');
    Route::post('customer_invoice/edit/{invoice}',[\App\Http\Controllers\InvoiceCustomerController::class,'update'])->name('invoice_customer.update');
    Route::post('customer_invoice/delete/{invoice}',[\App\Http\Controllers\InvoiceCustomerController::class,'destroy'])->name('invoice_customer.destroy');


    //end customer invoice
});

Route::get('/{page}', [\App\Http\Controllers\AdminController::class,'index'])->middleware('auth:admin,web');
