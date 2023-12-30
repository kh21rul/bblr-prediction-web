<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardDatasetController;
use App\Http\Controllers\DashboardDataujiController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login')->middleware('guest');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::resource('/dashboard/datasets', DashboardDatasetController::class)->middleware('auth')->except('show')->names([
    'index' => 'dashboard.datasets.index',
    'create' => 'dashboard.datasets.create',
    'store' => 'dashboard.datasets.store',
    'edit' => 'dashboard.datasets.edit',
    'update' => 'dashboard.datasets.update',
    'destroy' => 'dashboard.datasets.destroy',
]);

Route::resource('/dashboard/dataujis', DashboardDataujiController::class)->middleware('auth')->except('show')->names([
    'index' => 'dashboard.dataujis.index',
    'create' => 'dashboard.dataujis.create',
    'store' => 'dashboard.dataujis.store',
    'edit' => 'dashboard.dataujis.edit',
    'update' => 'dashboard.dataujis.update',
    'destroy' => 'dashboard.dataujis.destroy',
]);

Route::get('/dashboard/datauji/simpannb/{datauji}', [DashboardDataujiController::class, 'simpannb'])->middleware('auth')->name('dashboard.dataujis.simpannb');
Route::get('/dashboard/datauji/simpanc45/{datauji}', [DashboardDataujiController::class, 'simpanc45'])->middleware('auth')->name('dashboard.dataujis.simpanc45');
