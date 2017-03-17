<?php
namespace JokerLinly\Blog\Providers;

use JokerLinly\Blog\Blog;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class BlogServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('blog', function ($app) {
            return new Blog;
        });
    }
}
