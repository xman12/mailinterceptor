<?php

namespace MailInterceptor\DTO;

/**
 * Mail headers DTO
 */
class MailHeadersDTO
{
    public const HEADER_MESSAGE_ID = 'Message-ID';
    public const HEADER_DATE = 'Date';
    public const HEADER_SUBJECT = 'Subject';
    public const HEADER_FROM = 'From';
    public const HEADER_TO = 'To';
    public const HEADER_MIME_VERSION = 'MIME-Version';
    public const HEADER_CONTENT_TYPE = 'Content-Type';
    public const HEADER_CONTENT_TRANSFER_ENCODING = 'Content-Transfer-Encoding';
    public const HEADERS = [
        self::HEADER_MESSAGE_ID,
        self::HEADER_DATE,
        self::HEADER_SUBJECT,
        self::HEADER_FROM,
        self::HEADER_TO,
        self::HEADER_MIME_VERSION,
        self::HEADER_CONTENT_TYPE,
        self::HEADER_CONTENT_TRANSFER_ENCODING,
    ];

    /** @var string|null */
    private $messageId;

    /** @var string|null */
    private $date;

    /** @var string|null */
    private $subject;

    /** @var string|null */
    private $from;

    /** @var string|null */
    private $to;

    /** @var string|null */
    private $mimeVersion;

    /** @var string|null */
    private $contentTransferEncoding;

    /** @var string|null */
    private $contentType;

    /**
     * Create DTO from array
     *
     * @param array $data
     *
     * @return static
     */
    public static function createFromArray(array $data): self
    {
        $self = new self();
        $self->to = $data[self::HEADER_TO] ?? null;
        $self->contentTransferEncoding = $data[self::HEADER_CONTENT_TRANSFER_ENCODING] ?? null;
        $self->date = $data[self::HEADER_DATE] ?? null;
        $self->from = $data[self::HEADER_FROM] ?? null;
        $self->messageId = $data[self::HEADER_MESSAGE_ID] ?? null;
        $self->mimeVersion = $data[self::HEADER_MIME_VERSION] ?? null;
        $self->subject = $data[self::HEADER_SUBJECT] ?? null;
        $self->contentType = $data[self::HEADER_CONTENT_TYPE] ?? null;

        return $self;
    }

    /**
     * Get array data
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'to' => $this->getTo(),
            'contentTransferEncoding' => $this->getContentTransferEncoding(),
            'date' => $this->getDate(),
            'from' => $this->getFrom(),
            'messageId' => $this->getMessageId(),
            'mimeVersion' => $this->getMimeVersion(),
            'subject' => $this->getSubject(),
            'contentType' => $this->getContentType(),
        ];
    }

    /**
     * @return string|null
     */
    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->isImap($this->subject) ? $this->imapUtf8Fix($this->subject) : $this->subject;
    }

    /**
     * @return string|null
     */
    public function getFrom(): ?string
    {
        return $this->isImap($this->from) ? $this->imapUtf8Fix($this->from) : $this->from;
    }

    /**
     * @return string|null
     */
    public function getTo(): ?string
    {
        return $this->isImap($this->to) ? $this->imapUtf8Fix($this->to) : $this->to;
    }

    /**
     * @return string|null
     */
    public function getMimeVersion(): ?string
    {
        return $this->mimeVersion;
    }

    /**
     * @return string|null
     */
    public function getContentTransferEncoding(): ?string
    {
        return $this->contentTransferEncoding;
    }

    /**
     * @return string|null
     */
    public function getContentType(): ?string
    {
        return $this->contentType;
    }

    /**
     * @param $string
     * @return false|string
     */
    private function imapUtf8Fix($string)
    {
        return iconv_mime_decode($string, 0, "UTF-8");
    }

    private function isImap(string $string): bool
    {
        if (strpos($string, '=?utf-8?') !== false) {
            return true;
        }

        return false;
    }

}
