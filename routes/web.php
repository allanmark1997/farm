<?php

use App\Http\Controllers\FarmController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('farmers')->name('farmers.')->group(function () {
        Route::get('/', [FarmerController::class, 'index'])->name('index');
        Route::post('/store', [FarmerController::class, 'store'])->name('store');
        Route::put('/update/{id}', [FarmerController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [FarmerController::class, 'destroy'])->name('delete');
    });

    Route::prefix('maps')->name('maps.')->group(function () {
        Route::get('/', [MapController::class, 'index'])->name('index');
        Route::post('/store', [MapController::class, 'store'])->name('store');
        Route::put('/update/{id}', [MapController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [MapController::class, 'destroy'])->name('delete');
    });


    Route::prefix('farms')->name('farms.')->group(function () {
        Route::get('/', [FarmController::class, 'index'])->name('index');
        Route::post('/store', [FarmController::class, 'store'])->name('store');
        Route::put('/update/{id}', [FarmController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [FarmController::class, 'destroy'])->name('delete');
    });

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::post('/store', [InventoryController::class, 'store'])->name('store');
        Route::put('/update/{id}', [InventoryController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [InventoryController::class, 'destroy'])->name('delete');
    });

    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::post('/store', [TransactionController::class, 'store'])->name('store');
        Route::put('/update/{id}', [TransactionController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [TransactionController::class, 'destroy'])->name('delete');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
    });
});
