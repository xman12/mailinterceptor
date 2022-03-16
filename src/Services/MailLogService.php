<?php

namespace MailInterceptor\Services;

use MailInterceptor\DTO\MailDTO;
use JsonException;

class MailLogService implements MailLogServiceInterface
{
    protected $app;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @return MailDTO[]
     * @throws JsonException
     */
    public function getMails(): array
    {
        $data = file($this->getPath());
        $mails = [];
        foreach ($data as $item) {
            $mailItem = explode('DEBUG:', $item);
            $mailData = json_decode(trim($mailItem[1]), true, 512, JSON_THROW_ON_ERROR);
            $mails[] = new MailDTO(current($mailData));
        }

        return $mails;
    }

    /**
     * @throws JsonException
     */
    public function getMailById(int $id): ?MailDTO
    {
        return $this->getMails()[$id] ?? null;
    }

    public function deleteById(int $id): void
    {
        $data = file($this->getPath());
        if (isset($data[$id])) {
            unset($data[$id]);
        }

        $fp = fopen($this->getPath(), 'wb');
        fwrite($fp, implode("", $data));
        fclose($fp);
    }

    public function flush()
    {
        $fp = fopen($this->getPath(), 'wb');
        fclose($fp);
    }


    private function getPath()
    {
        return storage_path('logs') . DIRECTORY_SEPARATOR . $this->app['config']['mail.mail_interceptor_log'];
    }
}
