<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PartnerController;
use App\Models\Partner;
use App\Models\Category;

Route::get('/', function () {
    return view('welcome', [
        'partners' => Partner::all(),
        'categories' => Category::all()
    ]);
});
Route::resource('partners', PartnerController::class);

Route::resource('categories', CategoryController::class);
Route::resource('admin/categories', CategoryController::class);
Route::get('/', [WelcomeController::class, 'index']);
Route::resource('admin/events', EventController::class);

// Rute User Area
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/1', [EventController::class,
'show'])->name('events.show');
Route::get('/checkout', [EventController::class,
'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

// Rute Admin Area
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

Route::get('/', [DashboardController::class,

'index'])->name('dashboard');

Route::get('/events', [EventController::class,

'indexAdmin'])->name('events.index');
});
Route::get('/event', [EventController::class, 'show'])->name('event.detail');

Route::get('/admin/categories', [CategoryController::class, 'index'])
    ->name('admin.categories');