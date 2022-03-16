<?php

namespace MailInterceptor\Providers;

use MailInterceptor\Services\{MailLogService, MailLogServiceInterface};
use Illuminate\Support\ServiceProvider;

/**
 * Registration app services
 */
class AppMailInterceptorServiceProvider extends ServiceProvider
{
    /**
     * Registration services
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MailLogServiceInterface::class, function ($app) {
            return new MailLogService($app);
        });
    }

    public function boot()
    {
        //
    }
}
