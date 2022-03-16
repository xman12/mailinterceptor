<?php

namespace MailInterceptor\Services;

use Illuminate\Log\LogManager;
use Illuminate\Mail\TransportManager;
use Psr\Log\LoggerInterface;

class TransportMailManager extends TransportManager
{
    protected function createMailInterceptorDriver()
    {
        $logger = $this->app->make(LoggerInterface::class);

        if ($logger instanceof LogManager) {
            $logger = $logger->channel('mail_interceptor_log');
        }

        return new MailInterceptorTransport($logger, $this->app['config']['mail.mail_interceptor_log']);
    }
}
