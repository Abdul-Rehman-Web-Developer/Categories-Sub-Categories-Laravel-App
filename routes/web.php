<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;
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

Route::get('/', [GeneralController::class, 'index'])->name('home');
Route::post('add_category', [GeneralController::class, 'add_category'])->name('add_category');
Route::post('add_sub_category', [GeneralController::class, 'add_sub_category'])->name('add_sub_category');
Route::post('delete_sub_category', [GeneralController::class, 'delete_sub_category'])->name('delete_sub_category');
Route::post('delete_category', [GeneralController::class, 'delete_category'])->name('delete_category');