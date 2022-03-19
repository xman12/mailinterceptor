<?php

namespace MailInterceptor\Providers;

use Closure;
use Illuminate\Routing\UrlGenerator;
use MailInterceptor\Services\{MailLogService, MailLogServiceInterface};
use Illuminate\Support\ServiceProvider;

/**
 * Registration app services
 */
class AppMailInterceptorServiceProvider extends ServiceProvider
{
    /**
     * Registration services
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MailLogServiceInterface::class, function ($app) {
            return new MailLogService($app);
        });

        $this->app->singleton("url", function($app) {
            $routes = $app['router']->getRoutes();
            return new MailInterceptorUrlGenerator(  // this is actually my class due to the namespace above
                $routes, $app->rebinding(
                'request', $this->requestRebinder()
            ), $app['config']['app.asset_url']
            );
        });
    }

    /**
     * @return Closure
     */
    protected function requestRebinder()
    {
        return function ($app, $request) {
            $app['url']->setRequest($request);
        };
    }

    public function boot()
    {
        //
    }
}
