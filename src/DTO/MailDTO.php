<?php

namespace MailInterceptor\DTO;

/**
 * Mail DTO
 */
class MailDTO
{
    /** @var string|null */
    private ?string $time;

    /** @var MailHeadersDTO|null */
    private ?MailHeadersDTO $headers;

    /** @var string|null */
    private ?string $body;

    public function __construct(array $data, string $time)
    {
        $this->body = $data['body'];
        $this->headers = MailHeadersDTO::createFromArray($data['headers']);
        $this->time = $time;
    }

    /**
     * @return MailHeadersDTO|null
     */
    public function getHeaders(): ?MailHeadersDTO
    {
        return $this->headers;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @return string|null
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * Get array data
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'time' => $this->getTime(),
            'headers' => null !== $this->getHeaders() ? $this->getHeaders()->toArray() : null,
            'body' => $this->getBody(),
        ];
    }

}
