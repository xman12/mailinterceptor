<?php

namespace MailInterceptor\Providers;

use Illuminate\Routing\UrlGenerator;

class MailInterceptorUrlGenerator extends UrlGenerator
{
    public function asset($path, $secure = null)
    {
        $prefix = $this->getRequest()->route()->getPrefix();
        if ('mailinterceptor' === $prefix) {
            $path = $this->resolveAssetPath($path);

            return $path;
        }

        return parent::asset($path, $secure);
    }

    protected function resolveAssetPath($path)
    {
        return $this->route('mailinterceptor.assets', ['path' => $path]);
    }
}