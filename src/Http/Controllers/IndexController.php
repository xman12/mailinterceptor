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

    /** @var MailLogServiceInterface  */
    protected MailLogServiceInterface $mailLogService;

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

        return View::file(self::PATH_VIEW . DIRECTORY_SEPARATOR . 'index.blade.php', [
            'mails' => $mails,
            'selectedMail' => $selectedMail,
            'id' => $id
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexApiAction(Request $request)
    {
        $mails = $this->mailLogService->getMails();
        if (empty($mails)) {
            throw new RuntimeException('Email database is empty');
        }

        return response()->json(
            [
                'result' => $mails,
            ]
        );
    }


    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showMailAction(int $id)
    {
        $mail = $this->mailLogService->getMailById($id);
        if (null === $mail) {
            throw new RuntimeException('Error, email not found');
        }

        return View::file(self::PATH_VIEW . DIRECTORY_SEPARATOR . 'view.blade.php', [
            'body' => $mail->getBody(),
            'headers' => $mail->getHeaders(),
        ]);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function viewAction(int $id)
    {
        $mail = $this->mailLogService->getMailById($id);
        if (null === $mail) {
            throw new RuntimeException('Error, email not found');
        }

        return View::file(self::PATH_VIEW . DIRECTORY_SEPARATOR . 'view.blade.php', [
            'body' => $mail->getBody(),
        ]);
    }

    /**
     * Delete element from database
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteMailAction(int $id)
    {
        $this->mailLogService->deleteById($id);

        return redirect(route('mailinterceptor.index'));
    }

    /**
     * Flush data from base
     *
     * @return void
     */
    public function flushAction()
    {
        $this->mailLogService->flush();
    }

    /**
     * Get static for page
     *
     * @param $path
     * @return BinaryFileResponse
     */
    public function webAssetAction($path)
    {
        $asset = (new Web())->asset($path);

        if (!$asset) {
            throw new NotFoundHttpException;
        }

        return new BinaryFileResponse($asset['path'], 200, ['Content-Type' => $asset['mime']]);
    }
}
