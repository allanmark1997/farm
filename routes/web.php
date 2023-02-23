<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Event;
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
    $events = Event::orderBy('created_at', 'desc')->limit(10)->get();
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'events' => $events
    ]);
});


Route::post('/authenticate', [UserController::class, 'authenticate'])->name('authenticate');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('timelines')->name('timeline.')->group(function () {
        Route::get('/', [TimelineController::class, 'index'])->name('index');
        Route::post('/store', [TimelineController::class, 'store'])->name('store');
        Route::put('/update/{id}', [TimelineController::class, 'update'])->name('update');
        Route::delete('/delete', [TimelineController::class, 'destroy'])->name('delete');
    });

    Route::prefix('events')->name('event.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::post('/store', [EventController::class, 'store'])->name('store');
        Route::post('/update/{id}', [EventController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [EventController::class, 'destroy'])->name('delete');
    });

    Route::prefix('farmers')->name('farmers.')->group(function () {
        Route::get('/', [FarmerController::class, 'index'])->name('index');
        Route::post('/store', [FarmerController::class, 'store'])->name('store');
        Route::put('/update/{id}', [FarmerController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [FarmerController::class, 'destroy'])->name('delete');
        Route::get('/farms/{farmer_id}', [FarmController::class, 'farms'])->name('farms');
        Route::put('/toggle_status/{id}', [FarmerController::class, 'toggle_status'])->name('toggle_status');
        Route::get('/profile', [FarmerController::class, 'profile'])->name('profile');
        Route::get('/add_farmer_page', [FarmerController::class, 'add_farmer_page'])->name('add_farmer_page');


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
        Route::put('/plant/{id}', [FarmController::class, 'plant'])->name('plant');
        Route::put('/harvest/{id}', [FarmController::class, 'harvest'])->name('harvest');
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
        Route::put('/toggle_status/{id}', [UserController::class, 'toggle_status'])->name('toggle_status');
    });

    Route::prefix('analysis')->name('analysis.')->group(function () {
        Route::get('/', [FarmController::class, 'index_analysis'])->name('index_analysis');
        Route::post('/download', [FarmController::class, 'download'])->name('download');
    });
});
