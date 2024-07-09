<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\TermController;
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

require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {
    Route::get('home', [Admin\HomeController::class, 'index'])->name('home');
    Route::resource('users', Admin\UserController::class)->only(['index', 'show']);
    Route::resource('restaurants', Admin\RestaurantController::class);
    Route::resource('categories', Admin\CategoryController::class);
//});
//Route::prefix('admin')->name('admin.')->group(function () {
    //Route::get('company', [CompanyController::class, 'index'])->name('company.index');
    //Route::get('company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    //Route::post('company/{company}/update', [CompanyController::class, 'update'])->name('company.update');
//});
//Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {
    //Route::get('home', [Admin\HomeController::class, 'index'])->name('home');
    //Route::resource('users', Admin\UserController::class)->only(['index', 'show']);
    //Route::resource('restaurants', Admin\RestaurantController::class);
    //Route::resource('categories', Admin\CategoryController::class);

    // Company routes
    //Route::get('company', [CompanyController::class, 'index'])->name('company.index');
    //Route::get('company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    //Route::post('company/{company}/update', [CompanyController::class, 'update'])->name('company.update');

    // Term routes
    //Route::get('terms', [TermController::class, 'index'])->name('terms.index');
    Route::get('terms/{term}/edit', [TermController::class, 'edit'])->name('terms.edit');
    Route::post('terms/{term}/update', [TermController::class, 'update'])->name('terms.update');
//});
// Company routes
Route::get('company', [CompanyController::class, 'index'])->name('company.index');
Route::get('company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
Route::patch('company/{company}/update', [CompanyController::class, 'update'])->name('company.update');

// Term routes
Route::get('terms', [TermController::class, 'index'])->name('terms.index');
Route::get('terms/{term}/edit', [TermController::class, 'edit'])->name('terms.edit');
Route::patch('terms/{term}/update', [TermController::class, 'update'])->name('terms.update');
});