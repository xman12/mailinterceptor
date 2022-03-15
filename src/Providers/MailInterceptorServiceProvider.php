<?php

namespace MailInterceptor\Providers;

use MailInterceptor\Services\TransportMailManager;
use Illuminate\Mail\MailServiceProvider;

class MailInterceptorServiceProvider extends MailServiceProvider
{
    protected function registerSwiftTransport()
    {
        $this->app->singleton('swift.transport', function () {
            return new TransportMailManager($this->app);
        });
    }
}
