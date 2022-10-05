<?php

namespace MailInterceptor\Services;

use MailInterceptor\DTO\MailDTO;

/**
 * Интерфейс сервиса по взаимодействию с логами
 */
interface MailLogServiceInterface
{
    /**
     * @param bool $toArray
     * @return MailDTO[]
     */
    public function getMails(bool $toArray = false): array;

    /**
     * @param int $id
     * @return MailDTO|null
     */
    public function getMailById(int $id): ?MailDTO;

    /**
     * @return void
     */
    public function flush(): void;

    /**
     * @param int $id
     * @return void
     */
    public function deleteById(int $id): void;
}
