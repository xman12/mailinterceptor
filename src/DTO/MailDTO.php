<?php

namespace MailInterceptor\DTO;

class MailDTO
{
    /** @var string */
    private $time;

    /** @var MailHeadersDTO */
    private $headers;

    /** @var string  */
    private $body;

    public function __construct(array $data, string $time)
    {
        $this->body = $data['body'];
        $this->headers = MailHeadersDTO::createFromArray($data['headers']);
        $this->time = $time;
    }

    /**
     * @return MailHeadersDTO
     */
    public function getHeaders(): MailHeadersDTO
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }
}
