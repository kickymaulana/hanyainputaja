<?php

use App\Http\Controllers\AssetConditionController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetStatusController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MasterDataController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/dashboard', DashboardController::class)->name('dashboard.index');

    Route::get('assets', [AssetController::class, 'index'])->name('assets.index');

    Route::middleware('role:admin,operator')->group(function (): void {
        Route::get('assets/create', [AssetController::class, 'create'])->name('assets.create');
        Route::post('assets', [AssetController::class, 'store'])->name('assets.store');
        Route::get('assets/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
        Route::put('assets/{asset}', [AssetController::class, 'update'])->name('assets.update');
    });

    Route::get('assets/{asset}', [AssetController::class, 'show'])->name('assets.show');

    Route::middleware('role:admin')->group(function (): void {
        Route::resource('categories', CategoryController::class)->except(['show', 'destroy']);
        Route::resource('locations', LocationController::class)->except(['show', 'destroy']);
        Route::resource('departments', DepartmentController::class)->except(['show', 'destroy']);
        Route::resource('asset-statuses', AssetStatusController::class)->except(['show', 'destroy']);
        Route::resource('asset-conditions', AssetConditionController::class)->except(['show', 'destroy']);
    });

    Route::get('/master', MasterDataController::class)->middleware('role:admin')->name('master.index');
    Route::get('/account', fn () => redirect()->route('dashboard'))->name('account.index');
});
