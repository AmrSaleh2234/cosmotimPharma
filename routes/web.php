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
    Route::post('product/destroy',[\App\Http\Controllers\ProdcutController::class,'destroy'])->name('product.destroy');
    //end product
    //start inventory
    Route::get('inventory',[\App\Http\Controllers\InventoryController::class,'index'])->name('inventory.index');
    Route::post('inventory/store',[\App\Http\Controllers\InventoryController::class,'store'])->name('inventory.store');
    Route::post('inventory/edit',[\App\Http\Controllers\InventoryController::class,'edit'])->name('inventory.edit');
    Route::post('inventory/destroy',[\App\Http\Controllers\InventoryController::class,'destroy'])->name('inventory.destroy');
    //end inventory
    //start account
    Route::get('account',[\App\Http\Controllers\AccountController::class,'index'])->name('account.index');
    Route::get('customer',[\App\Http\Controllers\AccountController::class,'customersView'])->name('customer.index');
    Route::get('account/create',[\App\Http\Controllers\AccountController::class,'create'])->name('account.create');
    Route::post('account/store',[\App\Http\Controllers\AccountController::class,'store'])->name('account.store');
    Route::post('account/edit',[\App\Http\Controllers\AccountController::class,'edit'])->name('account.edit');
    Route::post('account/destroy',[\App\Http\Controllers\AccountController::class,'destroy'])->name('account.destroy');
    //end account
});

Route::get('/{page}', [\App\Http\Controllers\AdminController::class,'index'])->middleware('auth:admin,web');
