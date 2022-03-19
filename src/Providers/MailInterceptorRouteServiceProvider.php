<?php

namespace MailInterceptor\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use MailInterceptor\Web;

/**
 * MailInterceptor routs
 */
class MailInterceptorRouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'MailInterceptor\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        // will be work only into local space
        if ('local' === $this->app['config']['app.env']) {
            Route::prefix(Web::SERVICE_NAME)->namespace($this->namespace)->group(function () {

                Route::get('/', 'IndexController@indexAction')->name('mailinterceptor.index');
                Route::get('/view/{id}/', 'IndexController@viewAction')->name('mailinterceptor.view');
                Route::get('/mail/{id}/', 'IndexController@showMailAction')->name('mailinterceptor.mail.show');
                Route::get('/delete/{id}/', 'IndexController@deleteMailAction')->name('mailinterceptor.mail.delete');
                Route::get('/clear/', 'IndexController@flushAction')->name('mailinterceptor.flush');
                Route::get('/test/', 'IndexController@testAction');
                Route::get('/assets/{path}/', 'IndexController@webAssetAction')->where('path', '.*')->name('mailinterceptor.assets');

            });
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
    }
}
