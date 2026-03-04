<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\DashboardController;

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
    return redirect()->route('login');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class , 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class , 'store']);
});

// Two-Factor Authentication Routes
Route::middleware('two-factor.pending')->group(function () {
    Route::get('two-factor', [TwoFactorController::class, 'create'])->name('two-factor.create');
    Route::post('two-factor', [TwoFactorController::class, 'store'])->name('two-factor.store');
});

Route::post('logout', [AuthenticatedSessionController::class , 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('ingredients', IngredientController::class);
    Route::resource('products', App\Http\Controllers\ProductController::class);
    Route::resource('overhead_costs', App\Http\Controllers\OverheadCostController::class);
    Route::resource('recipes', App\Http\Controllers\RecipeController::class);
    Route::resource('users', App\Http\Controllers\UserController::class)->except(['show']);
});