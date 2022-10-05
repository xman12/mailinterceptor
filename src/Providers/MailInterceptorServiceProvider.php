<?php

namespace MailInterceptor\Providers;

use MailInterceptor\Services\TransportMailManager;
use Illuminate\Mail\MailServiceProvider;
use MailInterceptor\Web;

/**
 * Registration mail service
 */
class MailInterceptorServiceProvider extends MailServiceProvider
{
    /**
     * Define MailInterceptor transport manager
     *
     * @return void
     */
    protected function registerSwiftTransport()
    {
        $this->app->singleton('swift.transport', function () {
            return new TransportMailManager($this->app);
        });
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        $providers = parent::provides();
        $providers[] = Web::SERVICE_NAME;

        return $providers;
    }
}
