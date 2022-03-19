<?php

namespace MailInterceptor\Providers;

use Illuminate\Routing\UrlGenerator;
use MailInterceptor\Web;

/**
 * Service for manager rules "assert" function into view template
 */
class MailInterceptorUrlGenerator extends UrlGenerator
{

    public function asset($path, $secure = null): string
    {
        $prefix = $this->getRequest()->route()->getPrefix();
        if (Web::SERVICE_NAME === $prefix) {

            return $this->resolveAssetPath($path).DIRECTORY_SEPARATOR;
        }

        return parent::asset($path, $secure);
    }

    /**
     * @param $path
     * @return string
     */
    protected function resolveAssetPath($path): string
    {
        return $this->route('mailinterceptor.assets', ['path' => $path]);
    }
}