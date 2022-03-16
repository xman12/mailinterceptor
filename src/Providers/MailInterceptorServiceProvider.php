<?php

namespace MailInterceptor\Providers;

use MailInterceptor\Services\{MailLogService, MailLogServiceInterface};
use MailInterceptor\Services\TransportMailManager;
use Illuminate\Mail\MailServiceProvider;

/**
 * Registration mail service
 */
class MailInterceptorServiceProvider extends MailServiceProvider
{
    protected function registerSwiftTransport()
    {
        $this->app->singleton('swift.transport', function () {
            return new TransportMailManager($this->app);
        });
        $this->registationServices();
    }

    /**
     * Registration services
     *
     * @return void
     */
    protected function registationServices()
    {
        $this->app->singleton(MailLogServiceInterface::class, MailLogService::class);
    }
}
