<?php

namespace App\Providers;

use App\Repositories\Contracts\{
    OrderRepositoryInterface,
    VideoRepositoryInterface,
};
use App\Repositories\{
    OrderRepository,
    VideoRepository,
};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        $this->app->bind(
            VideoRepositoryInterface::class, 
            VideoRepository::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
