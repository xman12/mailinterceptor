<?php

namespace MailInterceptor\Services;

use MailInterceptor\DTO\MailHeadersDTO;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Header\AbstractHeader;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Mime\Email;


/**
 * MailInterceptor mail transport
 */
class MailInterceptorTransport implements TransportInterface
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
    public function send(RawMessage $message, Envelope $envelope = null): ?SentMessage
    {
        $string = $message->toString();

        if (str_contains($string, 'Content-Transfer-Encoding: quoted-printable')) {
            $string = quoted_printable_decode($string);
        }
        $headers = [];
        if ($message instanceof Email) {
            foreach ($message->getHeaders()->all() as $header) {
                if ($header instanceof AbstractHeader) {
                    if (in_array($header->getName(), MailHeadersDTO::HEADERS, true)) {
                        $headers[$header->getName()] = $header->getBodyAsString();
                    }
                }
            }
            $string = $message->getHtmlBody();
        }
        $data = [
            'headers' => $headers,
            'body' => $string
        ];
        $dd = var_export(json_encode($data, JSON_UNESCAPED_UNICODE), true);
        $this->logger->debug($dd);

        return new SentMessage($message, $envelope ?? Envelope::create($message));
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

    public function __toString(): string
    {
        return 'mailinterceptor';
    }

}
