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
    protected function registerIlluminateMailer()
    {
        $this->app->singleton('mail.manager', function($app) {
            return new TransportMailManager($app);
        });

        // Copied from Illuminate\Mail\MailServiceProvider
        $this->app->bind('mailer', function ($app) {
            return $app->make('mail.manager')->mailer();
        });
    }

    /**
     *
     *
     * @return array
     */
    public function provides(): array
    {
        $providers = parent::provides();
        $providers[] = Web::SERVICE_NAME;

        return $providers;
    }
}
