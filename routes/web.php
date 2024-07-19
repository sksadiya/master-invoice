<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
//Language Translation

Route::group(['middleware' => ['auth', 'check.admin']], function () {
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');


//update profilr image 
Route::post('/update-profile-image/{id}', [App\Http\Controllers\Auth\RegisterController::class, 'updateProfileImage'])->name('updateProfileImage');
Route::post('/save-settings', [App\Http\Controllers\SettingsController::class, 'updateSettings'])->name('updateSettings');

Route::get('settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings');
Route::get('app-settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('app-settings');
// routes/web.php


Route::get('categories', [App\Http\Controllers\categoryController::class, 'index'])->name('categories');
Route::post('categories', [App\Http\Controllers\categoryController::class, 'store'])->name('category.add');
Route::put('/categories/{id}', [App\Http\Controllers\categoryController::class, 'update'])->name('category.update');
Route::delete('/categories/{id}', [App\Http\Controllers\categoryController::class, 'destroy'])->name('category.delete');


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

Route::get('product', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::post('products', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
Route::get('products', [App\Http\Controllers\ProductController::class, 'create'])->name('product.add');
Route::get('product/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
Route::post('product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.delete');

Route::get('invoice/add', [App\Http\Controllers\Invoices::class, 'create'])->name('invoice.add');
Route::post('invoice/add', [App\Http\Controllers\Invoices::class, 'store'])->name('invoice.store');
Route::get('invoice', [App\Http\Controllers\Invoices::class, 'index'])->name('invoices');
Route::delete('/invoice/{id}', [App\Http\Controllers\Invoices::class, 'destroy'])->name('invoice.delete');
Route::get('invoice/edit/{id}', [App\Http\Controllers\Invoices::class, 'edit'])->name('invoice.edit');
Route::post('invoice/update/{id}', [App\Http\Controllers\Invoices::class, 'update'])->name('invoice.update');
Route::get('invoice/{id}', [App\Http\Controllers\Invoices::class, 'show'])->name('invoice.show');
Route::get('/download-invoice/{id}', [App\Http\Controllers\Invoices::class, 'downloadInvoice'])->name('download.invoice');


Route::get('/states/{id}', [App\Http\Controllers\SettingsController::class, 'fetchStates'])->name('fetch.states');
Route::get('/cities/{id}', [App\Http\Controllers\SettingsController::class, 'fetchCities'])->name('fetch.cities');
Route::get('/clients/{id}', [App\Http\Controllers\Invoices::class, 'fetchClient'])->name('fetch.client');


Route::post('payment/add', [App\Http\Controllers\Payments::class, 'store'])->name('payment.store');
});

// Route::middleware('admin.guest')->group(function () {
//   // Guest-only routes here
//   Route::get('/welcome', function () {
//       return view('welcome');
//   })->name('welcome');
// });

// // Routes accessible only to authenticated admin users
// Route::middleware('admin.auth')->prefix('admin')->group(function () {
//   Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
//   // Add more admin routes here
// });