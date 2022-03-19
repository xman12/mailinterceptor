<?php

namespace MailInterceptor\Services;

use Illuminate\Log\LogManager;
use Illuminate\Mail\TransportManager;
use Psr\Log\LoggerInterface;

/**
 * MailInterceptor transport manager
 */
class TransportMailManager extends TransportManager
{
    /**
     * @return MailInterceptorTransport
     */
    protected function createMailInterceptorDriver()
    {
        $logger = $this->app->make(LoggerInterface::class);

        if ($logger instanceof LogManager) {
            $logger = $logger->channel('mail_interceptor_log');
        }

        return new MailInterceptorTransport($logger);
    }
}
