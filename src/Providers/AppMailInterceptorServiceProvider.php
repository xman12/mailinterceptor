<?php

namespace MailInterceptor\Providers;

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

//        $this->app->bind('url', MailInterceptorUrlGenerator::class);
//        $this->app->singleton('url', function ($app) {
//            /** @var \Illuminate\Foundation\Application $app */
//            $routes = $app['router']->getRoutes();
//
//            $app->instance('routes', $routes);
//
//            // *** THIS IS THE MAIN DIFFERENCE ***
//            $url = new MailInterceptorUrlGenerator(
//                $routes,
//                $app->rebinding(
//                    'request',
//                    static function ($app, $request) {
//                        $app['url']->setRequest($request);
//                    }
//                ),
//                $app['config']['app.asset_url']
//            );
//
//            $url->setSessionResolver(function () {
//                return $this->app['session'] ?? null;
//            });
//
//            $url->setKeyResolver(function () {
//                return $this->app->make('config')->get('app.key');
//            });
//
//            $app->rebinding('routes', static function ($app, $routes) {
//                $app['url']->setRoutes($routes);
//            });
//
//            return $url;
//        });
    }

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
