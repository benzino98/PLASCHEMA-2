<?php

use App\Http\Controllers\Api\V1\Admin\ContentController;
use App\Http\Controllers\Api\V1\PublicController;
use App\Http\Controllers\Api\V1\TokenController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    // Authentication
    Route::post('/auth/token', [TokenController::class, 'store'])
        ->middleware('throttle:api-auth')->name('auth.token');
    Route::delete('/auth/token', [TokenController::class, 'destroy'])
        ->middleware(['auth:sanctum', 'throttle:api-admin'])->name('auth.revoke');

    // Public content
    Route::middleware('throttle:api-public')->group(function () {
        Route::get('/plans', [PublicController::class, 'plans'])->name('plans.index');
        Route::get('/plans/{slug}', [PublicController::class, 'plan'])->name('plans.show');

        Route::get('/providers/search', [PublicController::class, 'providers'])->name('providers.search');
        Route::get('/providers', [PublicController::class, 'providers'])->name('providers.index');
        Route::get('/providers/{slug}', [PublicController::class, 'provider'])->name('providers.show');

        Route::get('/news', [PublicController::class, 'news'])->name('news.index');
        Route::get('/news/{slug}', [PublicController::class, 'article'])->name('news.show');

        Route::get('/faqs', [PublicController::class, 'faqs'])->name('faqs.index');
        Route::get('/downloads', [PublicController::class, 'downloads'])->name('downloads.index');
    });

    Route::post('/contact', [PublicController::class, 'contact'])
        ->middleware('throttle:api-contact')->name('contact.store');

    // Protected content management (admin and editor roles)
    Route::prefix('admin')->name('admin.')
        ->middleware(['auth:sanctum', 'token.role:admin,editor', 'throttle:api-admin'])
        ->group(function () {
            Route::get('/providers', [ContentController::class, 'providers']);
            Route::post('/providers', [ContentController::class, 'storeProvider']);
            Route::put('/providers/{provider}', [ContentController::class, 'updateProvider']);
            Route::delete('/providers/{provider}', [ContentController::class, 'deleteProvider']);

            Route::get('/plans', [ContentController::class, 'plans']);
            Route::post('/plans', [ContentController::class, 'storePlan']);
            Route::put('/plans/{plan}', [ContentController::class, 'updatePlan']);
            Route::delete('/plans/{plan}', [ContentController::class, 'deletePlan']);

            Route::get('/news', [ContentController::class, 'news']);
            Route::post('/news', [ContentController::class, 'storeNews']);
            Route::put('/news/{article}', [ContentController::class, 'updateNews']);
            Route::delete('/news/{article}', [ContentController::class, 'deleteNews']);

            Route::get('/faqs', [ContentController::class, 'faqs']);
            Route::post('/faqs', [ContentController::class, 'storeFaq']);
            Route::put('/faqs/{faq}', [ContentController::class, 'updateFaq']);
            Route::delete('/faqs/{faq}', [ContentController::class, 'deleteFaq']);

            Route::get('/downloads', [ContentController::class, 'downloads']);
            Route::put('/downloads/{download}', [ContentController::class, 'updateDownload']);
            Route::delete('/downloads/{download}', [ContentController::class, 'deleteDownload']);

            Route::middleware('token.role:admin')->group(function () {
                Route::get('/messages', [ContentController::class, 'messages']);
                Route::get('/messages/{message}', [ContentController::class, 'message']);
                Route::patch('/messages/{message}/read', [ContentController::class, 'readMessage']);
            });
        });
});
