<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HealthPlanController;
use App\Http\Controllers\Admin\HomeSettingController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProviderController as AdminProviderController;
use App\Http\Controllers\Admin\ServiceSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/health-plans', [PageController::class, 'healthPlans'])->name('health-plans');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/providers', [ProviderController::class, 'index'])->name('providers');
Route::get('/providers/{provider:slug}', [ProviderController::class, 'show'])->name('providers.show');
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/resources', [DownloadController::class, 'index'])->name('resources');
Route::get('/resources/{download:slug}/download', [DownloadController::class, 'download'])->name('downloads.download');
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    });

    // Authenticated Routes
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('providers', AdminProviderController::class)
            ->except(['show'])
            ->parameters(['provider' => 'id']);

        // Messages
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
        Route::post('/messages/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
        Route::post('/messages/{message}/unread', [MessageController::class, 'markAsUnread'])->name('messages.unread');

        // FAQs
        Route::resource('faqs', App\Http\Controllers\Admin\FaqController::class)->except(['show']);

        // Pages
        Route::get('/pages', [App\Http\Controllers\Admin\PageController::class, 'index'])->name('pages.index');
        Route::get('/pages/{page}/edit', [App\Http\Controllers\Admin\PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [App\Http\Controllers\Admin\PageController::class, 'update'])->name('pages.update');

        // Health Plans
        Route::resource('health-plans', HealthPlanController::class)
            ->except(['show'])
            ->parameters(['health-plan' => 'healthPlan']);

        // News
        Route::resource('news', App\Http\Controllers\Admin\NewsController::class)->except(['show']);

        // Downloads
        Route::resource('downloads', App\Http\Controllers\Admin\DownloadController::class)->except(['show']);

        // Home Settings
        Route::get('/settings/home', [HomeSettingController::class, 'edit'])->name('settings.home');
        Route::put('/settings/home', [HomeSettingController::class, 'update'])->name('settings.home.update');
        Route::get('/settings/services', [ServiceSettingController::class, 'edit'])->name('settings.services');
        Route::put('/settings/services', [ServiceSettingController::class, 'update'])->name('settings.services.update');

        // User management (admin only)
        Route::resource('users', UserController::class)->except(['show'])->middleware('role:admin');
    });
});
