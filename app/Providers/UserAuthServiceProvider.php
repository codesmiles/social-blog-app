<?php

namespace App\Providers;

use App\Repository\AuthRepository;

use Illuminate\Support\ServiceProvider;

class UserAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(AuthInterface::class, AuthRepository::class);

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
