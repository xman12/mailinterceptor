<?php

namespace MailInterceptor\Providers;

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
    }

    public function provides()
    {
        $providers = parent::provides();
        array_push($providers, 'mailinterceptor');

        return $providers;
    }
}
