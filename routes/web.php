<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/health-plans', [PageController::class, 'healthPlans'])->name('health-plans');
Route::get('/providers', [PageController::class, 'providers'])->name('providers');
Route::get('/news', [PageController::class, 'news'])->name('news');
Route::get('/resources', [PageController::class, 'resources'])->name('resources');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
