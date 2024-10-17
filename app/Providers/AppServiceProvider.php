<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Ignore default migration from here
        Sanctum::ignoreMigrations();
        //
        $this->app->bind(
            \App\Http\Repositories\Interfaces\AuthorRepositoryInterface::class,
            \App\Http\Repositories\AuthorRepository::class
        );

        $this->app->bind(
            \App\Http\Repositories\Interfaces\BookRepositoryInterface::class,
            \App\Http\Repositories\BookRepository::class
        );

        // Binding services
        $this->app->bind(
            \App\Http\Services\Interfaces\AuthorServiceInterface::class,
            \App\Http\Services\AuthorService::class
        );

        $this->app->bind(
            \App\Http\Services\Interfaces\BookServiceInterface::class,
            \App\Http\Services\BookService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
