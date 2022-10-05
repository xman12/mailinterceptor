<?php

namespace MailInterceptor\Services;

use MailInterceptor\DTO\MailHeadersDTO;
use Illuminate\Mail\Transport\Transport;
use Psr\Log\LoggerInterface;
use Swift_Mime_SimpleMessage;
use Swift_Mime_SimpleMimeEntity;

/**
 * MailInterceptor mail transport
 */
class MailInterceptorTransport extends Transport
{
    /**
     * The Logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Create a new log transport instance.
     *
     * @param \Psr\Log\LoggerInterface $logger
     * @return void
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        try {
            $this->logger->debug($this->getMimeEntityString($message));
        } catch (\Exception $e) {

        }

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
        $data [] = [
            'headers' => $headersData,
            'body' => $body
        ];

        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    /**
     * Parse header parameters
     *
     * @param array $headers
     * @return array
     */
    private function parseParams(array $headers): array
    {
        $params = [];
        $lastHeader = null;
        foreach ($headers as $header) {
            $data = explode(':', $header);
            $value = null;
            if (isset($data[1])) {
                $value = trim($data[1]);
            }

            if (in_array($data[0], MailHeadersDTO::HEADERS, true)) {
                $params[$data[0]] = $value;
                $lastHeader = $data[0];
            } else if (in_array($lastHeader, MailHeadersDTO::HEADERS, true)) {
                $params[$lastHeader] .= trim($header);
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
