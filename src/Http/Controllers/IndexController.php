<?php

namespace MailInterceptor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use JsonException;
use MailInterceptor\Services\MailLogServiceInterface;
use MailInterceptor\Web;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Main controller
 */
class IndexController extends Controller
{
    /** @var string path with views */
    protected const PATH_VIEW = __DIR__ . '/../../../resources/views';

    protected $mailLogService;

    public function __construct(MailLogServiceInterface $mailLogService)
    {
        $this->mailLogService = $mailLogService;
    }

    /**
     * @throws JsonException
     */
    public function indexAction(Request $request)
    {
        $mails = $this->mailLogService->getMails();
        $id = (int)$request->get('id', 0);
        $selectedMail = $mails[$id] ?? current($mails);
        if (empty($mails)) {
            throw new RuntimeException('Email database is empty');
        }

        return View::file(self::PATH_VIEW . '/index.blade.php', [
            'mails' => $mails,
            'selectedMail' => $selectedMail,
            'id' => $id
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

        return View::file(self::PATH_VIEW . '/view.blade.php', [
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

        return View::file(self::PATH_VIEW . '/view.blade.php', [
            'body' => $mail->getBody(),
        ]);
    }

    public function deleteMailAction(int $id)
    {
        $this->mailLogService->deleteById($id);

        return redirect(route('mailinterceptor.index'));
    }

    public function flushAction()
    {
        $this->mailLogService->flush();
    }

    public function webAssetAction($path)
    {
        $asset = (new Web())->asset($path);

        if (!$asset) {
            throw new NotFoundHttpException;
        }

        return new BinaryFileResponse($asset['path'], 200, ['Content-Type' => $asset['mime']]);
    }

}
