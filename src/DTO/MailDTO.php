<?php

namespace MailInterceptor\DTO;

class MailDTO
{
    /** @var MailHeadersDTO */
    private $headers;

    /** @var string  */
    private $body;

    public function __construct(array $data)
    {
        $this->body = $data['body'];
        $this->headers = MailHeadersDTO::createFromArray($data['headers']);
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
}
