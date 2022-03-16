<?php

namespace MailInterceptor\Providers;

use MailInterceptor\Services\{MailLogService, MailLogServiceInterface};
use Illuminate\Support\ServiceProvider;

/**
 * Registration app services
 */
class MailInterceptorServiceProvider extends ServiceProvider
{
    /**
     * Registration services
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MailLogServiceInterface::class, MailLogService::class);
    }

    public function boot()
    {
        //
    }
}
