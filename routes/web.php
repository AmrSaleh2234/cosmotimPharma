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
    return redirect()->route('admin.dashboard');
});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin', [LoginController::class, 'showAdminLoginForm'])->name('admin.login-view');
Route::post('/admin', [LoginController::class, 'adminLogin'])->name('admin.login');

Route::get('/admin/register', [RegisterController::class, 'showAdminRegisterForm'])->name('admin.register-view');
Route::post('/admin/register', [RegisterController::class, 'createAdmin'])->name('admin.register');

Route::get('/admin/dashboard',[\App\Http\Controllers\HomeController::class,'adminDashboard'] )->name('admin.dashboard')->middleware('auth:admin');

//    return view('admin.admin');





Route::group(['middleware' => 'auth:admin,web'], function () {
    //start product
    Route::get('product', [\App\Http\Controllers\ProdcutController::class, 'index']);
    Route::post('product/store', [\App\Http\Controllers\ProdcutController::class, 'store'])->name('product.store');
    Route::post('product/edit', [\App\Http\Controllers\ProdcutController::class, 'edit'])->name('product.edit');
    Route::post('product/activate', [\App\Http\Controllers\ProdcutController::class, 'activate'])->name('product.activate');
    //end product
    //start inventory
    Route::get('inventory', [\App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('inventory/store', [\App\Http\Controllers\InventoryController::class, 'store'])->name('inventory.store');
    Route::post('inventory/edit', [\App\Http\Controllers\InventoryController::class, 'edit'])->name('inventory.edit');
    Route::post('inventory/destroy', [\App\Http\Controllers\InventoryController::class, 'destroy'])->name('inventory.destroy');
    //end inventory
    //start customer
    Route::get('customer/invoicesInTable/{customer}', [\App\Http\Controllers\CustomerController::class, 'invoicesTable'])->name('customer.invoicesInTable');
    Route::get('customer', [\App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/start_balance/{id}', [\App\Http\Controllers\CustomerController::class, 'getStartBalance'])->name('customer.start-balance');
    Route::post('customer/pay', [\App\Http\Controllers\CustomerController::class, 'collect'])->name('customer.collect');
    Route::get('customer/create', [\App\Http\Controllers\CustomerController::class, 'create'])->name('customer.create');
    Route::post('customer/store', [\App\Http\Controllers\CustomerController::class, 'store'])->name('customer.store');
    Route::get('customer/edit/{customer}', [\App\Http\Controllers\CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('customer/update/{customer}', [\App\Http\Controllers\CustomerController::class, 'update'])->name('customer.update');
    Route::post('customer/destroy', [\App\Http\Controllers\CustomerController::class, 'destroy'])->name('customer.destroy');
    //end customer
    //start customer invoice
    Route::post('customer_invoice/collect', [\App\Http\Controllers\InvoiceCustomerController::class, 'collect'])->name('invoice_customer.collect');
    Route::get('customer_invoice/print/{invoice}', [\App\Http\Controllers\InvoiceCustomerController::class, 'print'])->name('invoice_customer.print');
    Route::get('customer_invoice/searchbydate/{customer?}', [\App\Http\Controllers\InvoiceCustomerController::class, 'searchDate'])->name('invoice_customer.searchDate');
    Route::get('customer_invoice/{customer?}', [\App\Http\Controllers\InvoiceCustomerController::class, 'index'])->name('invoice_customer.index');
    Route::get('customer_invoice/payment/{invoice}', [\App\Http\Controllers\InvoiceCustomerController::class, 'payment'])->name('invoice_customer.payment');
    Route::get('customer_invoice/details/{invoice}', [\App\Http\Controllers\InvoiceCustomerController::class, 'orderDetails'])->name('invoice_customer.orderDetails');
    Route::get('customer_invoice/create/{account}', [\App\Http\Controllers\InvoiceCustomerController::class, 'create'])->name('invoice_customer.create');
    Route::post('customer_invoice/store{account}', [\App\Http\Controllers\InvoiceCustomerController::class, 'store'])->name('invoice_customer.store');
    Route::get('customer_invoice/edit/{invoice}', [\App\Http\Controllers\InvoiceCustomerController::class, 'edit'])->name('invoice_customer.edit');
    Route::get('customer_invoice/return/{invoice}', [\App\Http\Controllers\InvoiceCustomerController::class, 'returns'])->name('invoice_customer.return');
    Route::post('customer_invoice/update/{invoice}', [\App\Http\Controllers\InvoiceCustomerController::class, 'update'])->name('invoice_customer.update');
    Route::post('customer_invoice/doReturn/{invoice}', [\App\Http\Controllers\InvoiceCustomerController::class, 'doRe\turn'])->name('invoice_customer.doReturn');
    Route::post('customer_invoice/delete/{invoice}', [\App\Http\Controllers\InvoiceCustomerController::class, 'destroy'])->name('invoice_customer.destroy');
    //start supplier
    Route::get('supplier/', [\App\Http\Controllers\SupplierControler::class, 'index'])->name('supplier.index');
    Route::get('supplier/start_balance/{id}', [\App\Http\Controllers\SupplierControler::class, 'getStartBalance'])->name('supplier.start-balance');
    Route::post('supplier/pay', [\App\Http\Controllers\SupplierControler::class, 'pay'])->name('supplier.pay');
    Route::get('supplier/create', [\App\Http\Controllers\SupplierControler::class, 'create'])->name('supplier.create');
    Route::post('supplier/store', [\App\Http\Controllers\SupplierControler::class, 'store'])->name('supplier.store');
    Route::get('supplier/edit/{supplier}', [\App\Http\Controllers\SupplierControler::class, 'edit'])->name('supplier.edit');
    Route::post('supplier/update/{supplier}', [\App\Http\Controllers\SupplierControler::class, 'update'])->name('supplier.update');

    //end supplier
    //start capital
    Route::get('capital/', [\App\Http\Controllers\CapitalController::class, 'index'])->name('capital.index');
    Route::post('capital/collect', [\App\Http\Controllers\CapitalController::class, 'collect'])->name('capital.collect');
    Route::post('capital/pay/', [\App\Http\Controllers\CapitalController::class, 'pay'])->name('capital.pay');
    Route::get('capital/create', [\App\Http\Controllers\CapitalController::class, 'create'])->name('capital.create');
    Route::post('capital/store', [\App\Http\Controllers\CapitalController::class, 'store'])->name('capital.store');
    Route::get('capital/edit/{capital}', [\App\Http\Controllers\CapitalController::class, 'edit'])->name('capital.edit');
    Route::post('capital/update/{capital}', [\App\Http\Controllers\CapitalController::class, 'update'])->name('capital.update');
    Route::post('capital/delete', [\App\Http\Controllers\CapitalController::class, 'destroy'])->name('capital.destroy');


    //end capital
    //start expenses
    Route::get('expenses/', [\App\Http\Controllers\ExpensesController::class, 'index'])->name('expenses.index');
    Route::post('expenses/pay', [\App\Http\Controllers\ExpensesController::class, 'pay'])->name('expenses.pay');
    Route::get('expenses/create', [\App\Http\Controllers\ExpensesController::class, 'create'])->name('expenses.create');
    Route::post('expenses/store', [\App\Http\Controllers\ExpensesController::class, 'store'])->name('expenses.store');
    Route::get('expenses/edit/{expenses}', [\App\Http\Controllers\ExpensesController::class, 'edit'])->name('expenses.edit');
    Route::post('expenses/update/{expenses}', [\App\Http\Controllers\ExpensesController::class, 'update'])->name('expenses.update');
    Route::post('expenses/delete', [\App\Http\Controllers\ExpensesController::class, 'destroy'])->name('expenses.destroy');

    //end expenses
    //start gift
    Route::get('gift/', [\App\Http\Controllers\GiftController::class, 'index'])->name('gift.index');
    Route::get('gift/details/{invoice}', [\App\Http\Controllers\GiftController::class, 'orderDetails'])->name('gift.orderDetails');
    Route::get('gift/create', [\App\Http\Controllers\GiftController::class, 'create'])->name('gift.create');
    Route::post('gift/store', [\App\Http\Controllers\GiftController::class, 'store'])->name('gift.store');
    Route::get('gift/edit/{invoice}', [\App\Http\Controllers\GiftController::class, 'edit'])->name('gift.edit');
    Route::post('gift/edit/{invoice}', [\App\Http\Controllers\GiftController::class, 'update'])->name('gift.update');
    Route::post('gift/delete/{invoice}', [\App\Http\Controllers\GiftController::class, 'destroy'])->name('gift.destroy');
    //    //end gift
    //start employee
    Route::get('employee/', [\App\Http\Controllers\EmployeeController::class, 'index'])->name('employee.index');
    Route::get('employee/create', [\App\Http\Controllers\EmployeeController::class, 'create'])->name('employee.create');
    Route::post('employee/pay', [\App\Http\Controllers\EmployeeController::class, 'pay'])->name('employee.pay');
    Route::post('employee/store', [\App\Http\Controllers\EmployeeController::class, 'store'])->name('employee.store');
    Route::get('employee/edit/{employee}', [\App\Http\Controllers\EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('employee/update/{employee}', [\App\Http\Controllers\EmployeeController::class, 'update'])->name('employee.update');
    Route::post('employee/destroy', [\App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::get('employee/absent/{employee}',[\App\Http\Controllers\EmployeeController::class,'absent'])->name('employee.absent');
    Route::get('employee/attendance/{employee}',[\App\Http\Controllers\EmployeeController::class,'attendance'])->name('employee.attendance');
    Route::post('employee/reward/{employee}',[\App\Http\Controllers\EmployeeController::class,'reward'])->name('employee.reward');
    Route::get('employee/show/{employee}',[\App\Http\Controllers\EmployeeController::class,'show'])->name('employee.show');
//    Route::post('employee/expenses/{employee}',[\App\Http\Controllers\EmployeeController::class,'expenses'])->name('employee.expenses');
    //end employee
    //start supplier invoice
    Route::post('supplier_invoice/pay', [\App\Http\Controllers\InvoiceSupplierController::class, 'pay'])->name('invoice_supplier.pay');
    Route::get('supplier_invoice/print/{invoice}', [\App\Http\Controllers\InvoiceSupplierController::class, 'print'])->name('invoice_supplier.print');
    Route::get('supplier_invoice/searchbydate/{supplier?}', [\App\Http\Controllers\InvoiceSupplierController::class, 'searchDate'])->name('invoice_supplier.searchDate');

    Route::get('supplier_invoice/{supplier?}', [\App\Http\Controllers\InvoiceSupplierController::class, 'index'])->name('invoice_supplier.index');
    Route::get('supplier_invoice/details/{invoice}', [\App\Http\Controllers\InvoiceSupplierController::class, 'orderDetails'])->name('invoice_supplier.orderDetails');
    Route::get('supplier_invoice/create/{account}', [\App\Http\Controllers\InvoiceSupplierController::class, 'create'])->name('invoice_supplier.create');
    Route::post('supplier_invoice/store/{account}', [\App\Http\Controllers\InvoiceSupplierController::class, 'store'])->name('invoice_supplier.store');
    Route::get('supplier_invoice/edit/{invoice}', [\App\Http\Controllers\InvoiceSupplierController::class, 'edit'])->name('invoice_supplier.edit');
    Route::post('supplier_invoice/update/{invoice}', [\App\Http\Controllers\InvoiceSupplierController::class, 'update'])->name('invoice_supplier.update');
    Route::post('supplier_invoice/delete/{invoice}', [\App\Http\Controllers\InvoiceSupplierController::class, 'destroy'])->name('invoice_supplier.destroy');
    Route::get('supplier_invoice/payment/{invoice}', [\App\Http\Controllers\InvoiceSupplierController::class, 'payment'])->name('invoice_supplier.payment');

    //end supplier invoice
    //start reports
    Route::get('report/exchange/index',[\App\Http\Controllers\exchange::class,'index'])->name('exchange.index');
    //end reports
});

Route::get('/{page}', [\App\Http\Controllers\AdminController::class, 'index'])->middleware('auth:admin,web');
