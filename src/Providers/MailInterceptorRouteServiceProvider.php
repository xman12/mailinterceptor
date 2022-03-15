<?php

namespace MailInterceptor\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::prefix('mailinterceptor')->namespace($this->namespace)->group(function () {

            Route::get('/', 'IndexController@indexAction')->name('index');
            Route::get('/view/{id}', 'IndexController@viewAction')->name('view');
            Route::get('/mail/{id}', 'IndexController@showMailAction')->name('mail.show');
            Route::get('/delete/{id}', 'IndexController@deleteMailAction')->name('mail.delete');
            Route::get('/clear', 'IndexController@flushAction')->name('flush');
            Route::get('/test', 'IndexController@testAction');

        });

        //
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
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
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
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
