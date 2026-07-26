<?php

namespace App\Providers;

use App\Support\AssistantKnowledge;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('api-public', fn () => Limit::perMinute(60)->by(optional(request()->user())->id ?: request()->ip()));
        RateLimiter::for('api-contact', fn () => Limit::perMinute(5)->by(request()->ip()));
        RateLimiter::for('api-auth', fn () => Limit::perMinute(5)->by(request()->input('email', '').'|'.request()->ip()));
        RateLimiter::for('api-admin', fn () => Limit::perMinute(120)->by(request()->user()?->id ?: request()->ip()));

        View::composer('partials.assistant', function ($view) {
            try {
                $knowledge = AssistantKnowledge::build();
            } catch (\Throwable) {
                $knowledge = null;
            }

            $view->with('assistantKnowledge', $knowledge);
        });
    }
}
