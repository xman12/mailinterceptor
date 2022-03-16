<?php

namespace MailInterceptor\Services;

use MailInterceptor\DTO\MailHeadersDTO;
use Illuminate\Mail\Transport\Transport;
use Psr\Log\LoggerInterface;
use Swift_Mime_SimpleMessage;
use Swift_Mime_SimpleMimeEntity;

class MailInterceptorTransport extends Transport
{
    public const LOGGING_NAME = 'mail.log';

    /** @var string name log file */
    protected $logName;

    /**
     * The Logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Create a new log transport instance.
     *
     * @param  \Psr\Log\LoggerInterface  $logger
     * @return void
     */
    public function __construct(LoggerInterface $logger, string $logName)
    {
        $this->logger = $logger;
        $this->logName = $logName;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $this->logger->debug($this->getMimeEntityString($message));

        $this->sendPerformed($message);

        return $this->numberOfRecipients($message);
    }

    /**
     * Get a loggable string out of a Swiftmailer entity.
     *
     * @param \Swift_Mime_SimpleMimeEntity $entity
     * @return string
     * @throws \JsonException
     */
    protected function getMimeEntityString(Swift_Mime_SimpleMimeEntity $entity)
    {
        $headersString = $entity->getHeaders()->toString();
        $headers = explode("\r\n", $headersString);
        $headersData = $this->parseParams($headers);
        $body = $entity->getBody();
        $data []= [
            'headers' => $headersData,
            'body' => $body
        ];

        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    private function parseParams(array $headers): array
    {
        $params = [];
        foreach ($headers as $header) {
            $data = explode(':', $header);
            if (in_array($data[0], MailHeadersDTO::HEADERS, true)) {
                $params[$data[0]] = trim($data[1]);
            }
        }

        return $params;
    }

    /**
     * Get the logger for the LogTransport instance.
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function logger()
    {
        return $this->logger;
    }
}
