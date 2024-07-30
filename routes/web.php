<?php

use App\Exports\ClientsWithInvoicesExport;
use App\Exports\ClientsWithPaymentsExport;
use App\Exports\Invoices;
use App\Exports\Payments;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
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

Auth::routes();
Route::group(['middleware' => ['auth','check.user.role']], function () {
  Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
  Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
  Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
  Route::post('/update-profile-image/{id}', [App\Http\Controllers\Auth\RegisterController::class, 'updateProfileImage'])->name('updateProfileImage');
  Route::get('settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings');
  Route::get('/employee', [App\Http\Controllers\EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
// Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::post('/save-settings', [App\Http\Controllers\SettingsController::class, 'updateSettings'])->name('updateSettings');
Route::get('app-settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('app-settings');

Route::get('categories', [App\Http\Controllers\categoryController::class, 'index'])->name('categories');
Route::post('categories', [App\Http\Controllers\categoryController::class, 'store'])->name('category.add');
Route::put('/categories/{id}', [App\Http\Controllers\categoryController::class, 'update'])->name('category.update');
Route::delete('/categories/{id}', [App\Http\Controllers\categoryController::class, 'destroy'])->name('category.delete');

Route::get('expenseCategory', [App\Http\Controllers\expenseCategoryController::class, 'index'])->name('expenseCategories');
Route::post('expenseCategory', [App\Http\Controllers\expenseCategoryController::class, 'store'])->name('expenseCategory.add');
Route::put('/expenseCategories/{id}', [App\Http\Controllers\expenseCategoryController::class, 'update'])->name('expenseCategory.update');
Route::delete('/expenseCategories/{id}', [App\Http\Controllers\expenseCategoryController::class, 'destroy'])->name('expenseCategory.delete');

Route::group(['middleware' => ['permission:View Departments']], function () {
  Route::get('departments', [App\Http\Controllers\DepartmentController::class, 'index'])->name('departments');
});

Route::post('departments', [App\Http\Controllers\DepartmentController::class, 'store'])->name('department.add');
Route::put('/departments/{id}', [App\Http\Controllers\DepartmentController::class, 'update'])->name('department.update');
Route::delete('/departments/{id}', [App\Http\Controllers\DepartmentController::class, 'destroy'])->name('department.delete');

Route::get('employees', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employees');
Route::get('employee/add', [App\Http\Controllers\EmployeeController::class, 'create'])->name('employee.add');
Route::post('employee/store', [App\Http\Controllers\EmployeeController::class, 'store'])->name('employee.store');
Route::delete('/employee/{id}', [App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employee.delete');
Route::get('employee/edit/{id}', [App\Http\Controllers\EmployeeController::class, 'edit'])->name('employee.edit');
Route::post('employee/update/{id}', [App\Http\Controllers\EmployeeController::class, 'update'])->name('employee.update');
Route::get('employee/{id}', [App\Http\Controllers\EmployeeController::class, 'show'])->name('employee.show');

Route::get('taxes', [App\Http\Controllers\taxController::class, 'index'])->name('taxes');
Route::post('taxes', [App\Http\Controllers\taxController::class, 'store'])->name('tax.add');
Route::put('/taxes/{id}', [App\Http\Controllers\taxController::class, 'update'])->name('tax.update');
Route::delete('/taxes/{id}', [App\Http\Controllers\taxController::class, 'destroy'])->name('tax.delete');
Route::post('/taxes/{id}', [App\Http\Controllers\taxController::class, 'setDefaultTax'])->name('setDefault');

Route::get('client', [App\Http\Controllers\clientController::class, 'index'])->name('clients');
Route::post('clients', [App\Http\Controllers\clientController::class, 'store'])->name('client.store');
Route::get('clients', [App\Http\Controllers\clientController::class, 'create'])->name('client.add');
Route::get('client/edit/{id}', [App\Http\Controllers\clientController::class, 'edit'])->name('client.edit');
Route::post('client/update/{id}', [App\Http\Controllers\clientController::class, 'update'])->name('client.update');
Route::delete('/client/{id}', [App\Http\Controllers\clientController::class, 'destroy'])->name('client.delete');
Route::get('client/{id}', [App\Http\Controllers\clientController::class, 'show'])->name('client.show');
Route::get('export-payments/{id}', [App\Http\Controllers\clientController::class, 'exportClientPayments'])->name('exportClientPayments');
Route::get('export-invoices/{id}', [App\Http\Controllers\clientController::class, 'exportClientInvoices'])->name('exportClientInvoices');
Route::get('clients/{clientId}/export-with-invoices', function ($clientId) {
  return Excel::download(new ClientsWithInvoicesExport($clientId), 'client_' . $clientId . '_invoices.xlsx');
})->name('clients.export-with-invoices');
Route::get('clients/{clientId}/export-with-payments', function ($clientId) {
  return Excel::download(new ClientsWithPaymentsExport($clientId), 'client_' . $clientId . '_payments.xlsx');
})->name('clients.export-with-payments');

Route::get('product', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::post('products', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
Route::get('products', [App\Http\Controllers\ProductController::class, 'create'])->name('product.add');
Route::get('product/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
Route::post('product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.delete');

Route::get('roles', [App\Http\Controllers\RolesAndPermissions::class, 'index'])->name('roles');
Route::post('role', [App\Http\Controllers\RolesAndPermissions::class, 'store'])->name('role.store');
Route::get('role', [App\Http\Controllers\RolesAndPermissions::class, 'create'])->name('role.add');
Route::get('role/edit/{id}', [App\Http\Controllers\RolesAndPermissions::class, 'edit'])->name('role.edit');
Route::post('role/update/{id}', [App\Http\Controllers\RolesAndPermissions::class, 'update'])->name('role.update');
Route::delete('/role/{id}', [App\Http\Controllers\RolesAndPermissions::class, 'destroy'])->name('role.delete');

Route::get('invoice/add', [App\Http\Controllers\Invoices::class, 'create'])->name('invoice.add');
Route::post('invoice/add', [App\Http\Controllers\Invoices::class, 'store'])->name('invoice.store');
Route::get('invoice', [App\Http\Controllers\Invoices::class, 'index'])->name('invoices');
Route::delete('/invoice/{id}', [App\Http\Controllers\Invoices::class, 'destroy'])->name('invoice.delete');
Route::get('invoice/edit/{id}', [App\Http\Controllers\Invoices::class, 'edit'])->name('invoice.edit');
Route::post('invoice/update/{id}', [App\Http\Controllers\Invoices::class, 'update'])->name('invoice.update');
Route::get('invoice/{id}', [App\Http\Controllers\Invoices::class, 'show'])->name('invoice.show');
Route::get('/download-invoice/{id}', [App\Http\Controllers\Invoices::class, 'downloadInvoice'])->name('download.invoice');
Route::get('/download-invoices', [App\Http\Controllers\Invoices::class, 'exportInvoices'])->name('exportInvoices');
Route::get('export-invoices', function () {
  return Excel::download(new Invoices(), 'invoices.xlsx');
})->name('export-invoices');

Route::get('/states/{id}', [App\Http\Controllers\SettingsController::class, 'fetchStates'])->name('fetch.states');
Route::get('/cities/{id}', [App\Http\Controllers\SettingsController::class, 'fetchCities'])->name('fetch.cities');
Route::get('/clients/{id}', [App\Http\Controllers\Invoices::class, 'fetchClient'])->name('fetch.client');

Route::get('payments', [App\Http\Controllers\Payments::class, 'index'])->name('payments');
Route::post('payments', [App\Http\Controllers\Payments::class, 'store'])->name('payment.store');
Route::delete('/payment/{id}', [App\Http\Controllers\Payments::class, 'destroy'])->name('payment.delete');
Route::put('/payment/{id}', [App\Http\Controllers\Payments::class, 'update'])->name('payment.update');
Route::get('/download-payments', [App\Http\Controllers\Payments::class, 'exportPayments'])->name('exportPayments');
Route::get('export-payments', function () {
  return Excel::download(new Payments(), 'payments.xlsx');
})->name('export-payments');

Route::get('expenses', [App\Http\Controllers\ExpenseController::class, 'index'])->name('expenses');
Route::get('expense/add', [App\Http\Controllers\ExpenseController::class, 'create'])->name('expense.add');
Route::post('expenses', [App\Http\Controllers\ExpenseController::class, 'store'])->name('expense.store');
Route::get('/expense/edit/{id}', [App\Http\Controllers\ExpenseController::class, 'edit'])->name('expense.edit');
Route::delete('/expense/{id}', [App\Http\Controllers\ExpenseController::class, 'destroy'])->name('expense.delete');
Route::post('/expense/update/{id}', [App\Http\Controllers\ExpenseController::class, 'update'])->name('expense.update');
Route::get('expense/{id}', [App\Http\Controllers\ExpenseController::class, 'show'])->name('expense.show');

Route::get('/generate-pdf/{id}', [App\Http\Controllers\Invoices::class, 'generatePDF'])->name('generate');

Route::get('serviceCategories', [App\Http\Controllers\serviceCategoryController::class, 'index'])->name('serviceCategories');
Route::post('serviceCategories', [App\Http\Controllers\serviceCategoryController::class, 'store'])->name('serviceCategory.add');
Route::put('/serviceCategory/{id}', [App\Http\Controllers\serviceCategoryController::class, 'update'])->name('serviceCategory.update');
Route::delete('/serviceCategory/{id}', [App\Http\Controllers\serviceCategoryController::class, 'destroy'])->name('serviceCategory.delete');

});



