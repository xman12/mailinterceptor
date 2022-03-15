<?php

namespace MailInterceptor\Http\Controllers;

use MailInterceptor\Mail\Test;
use MailInterceptor\Services\MailLogService;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\View;
use JsonException;
use RuntimeException;

class IndexController extends Controller
{
    protected const PATH_VIEW = __DIR__.'/../../../resources/views';
    protected $mailLogService;

    public function __construct(MailLogService $mailLogService)
    {
        $this->mailLogService = $mailLogService;
    }

    /**
     * @throws JsonException
     */
    public function indexAction()
    {
        $mails = $this->mailLogService->getMails();

        return View::file(self::PATH_VIEW.'/index.blade.php', [
            'mails' => $mails
        ]);
    }

    /**
     * @throws JsonException
     */
    public function showMailAction(int $id)
    {
        $mail = $this->mailLogService->getMailById($id);
        if (null === $mail) {
            throw new RuntimeException('Error, email not found');
        }

        return View::file(self::PATH_VIEW.'/view.blade.php', [
            'body' => $mail->getBody(),
            'headers' => $mail->getHeaders(),
        ]);
    }

    /**
     * @throws JsonException
     */
    public function viewAction(int $id)
    {
        $mail = $this->mailLogService->getMailById($id);
        if (null === $mail) {
            throw new RuntimeException('Error, email not found');
        }

        return View::file(self::PATH_VIEW.'/view.blade.php', [
            'body' => $mail->getBody(),
        ]);
    }

    public function deleteMailAction(int $id)
    {
        $this->mailLogService->deleteById($id);
    }

    public function flushAction()
    {
        $this->mailLogService->flush();
    }

    public function testAction()
    {
        $mail = new Test();
        $mailer = app()->make(Mailer::class);
        $mail->to(['xman12@mail.ru', 'xman123@mail.ru'])->send($mailer);
    }

}
