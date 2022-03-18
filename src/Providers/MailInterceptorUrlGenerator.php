<?php

namespace MailInterceptor\Providers;

use Illuminate\Routing\UrlGenerator;

class MailInterceptorUrlGenerator extends UrlGenerator
{
    public function asset($path, $secure = null)
    {
        $prefix = $this->getRequest()->route()->getPrefix();
        if ('mailinterceptor' === $prefix) {

            return $this->resolveAssetPath($path);
        }

        return parent::asset($path, $secure);
    }

    protected function resolveAssetPath($path): string
    {
        return $this->route('mailinterceptor.assets', ['path' => $path]);
    }
}