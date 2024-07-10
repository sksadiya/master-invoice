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

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

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