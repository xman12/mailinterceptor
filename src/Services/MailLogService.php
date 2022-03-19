<?php

namespace MailInterceptor\Services;

use Illuminate\Contracts\Foundation\Application;
use MailInterceptor\DTO\MailDTO;
use JsonException;

/**
 * MailLog service
 */
class MailLogService implements MailLogServiceInterface
{
    /** @var Application */
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @inheritdoc
     * @throws JsonException
     */
    public function getMails(): array
    {
        $mails = [];
        if (is_file($this->getPath())) {
            $data = file($this->getPath());
            foreach ($data as $item) {
                $mailItem = explode('DEBUG:', $item);
                preg_match('#\[(.*)\]#', $mailItem[0], $timeData);
                $mailData = json_decode(trim($mailItem[1]), true, 512, JSON_THROW_ON_ERROR);
                $mails[] = new MailDTO(current($mailData), $timeData[1]);
            }
        }

        return $mails;
    }

    /**
     * @inheritdoc
     * @throws JsonException
     */
    public function getMailById(int $id): ?MailDTO
    {
        return $this->getMails()[$id] ?? null;
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function flush(): void
    {
        $fp = fopen($this->getPath(), 'wb');
        fclose($fp);
    }

    /**
     * Get path to log file
     *
     * @return string
     */
    private function getPath(): string
    {
        return storage_path('logs') . DIRECTORY_SEPARATOR . $this->app['config']['mail.mail_interceptor_log'];
    }
}
