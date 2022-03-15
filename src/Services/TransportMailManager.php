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
            $logger = $logger->channel($this->app['config']['mail.log_channel']);
        }

        return new MailInterceptorTransport($logger);
    }
}
