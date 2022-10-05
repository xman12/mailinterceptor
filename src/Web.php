<?php

namespace MailInterceptor;

// Helper class for serving app assets
class Web
{
    /** @var string */
    public const SERVICE_NAME = 'mailinterceptor';

    // Return the absolute path and a mime type of an asset
    public function asset($path)
    {
        $path = $this->resolveAssetPath($path);

        if (!$path) {
            return;
        }

        switch (pathinfo($path, PATHINFO_EXTENSION)) {
            case 'css':
                $mime = 'text/css';
                break;
            case 'js':
                $mime = 'application/javascript';
                break;
            case 'json':
                $mime = 'application/json';
                break;
            case 'png':
                $mime = 'image/png';
                break;
            default:
                $mime = 'text/html';
                break;
        }

        return [
            'path' => $path,
            'mime' => $mime
        ];
    }

    // Resolves absolute path of the asset
    protected function resolveAssetPath($path)
    {
        $publicPath = dirname(__DIR__) . '/resources';

        $path = realpath("$publicPath/$path");

        return 0 === strpos($path, $publicPath) ? $path : false;
    }
}
