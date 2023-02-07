<?php

namespace App\Providers;

use App\Interfaces\PostsInterface;
use App\Repository\PostsRepository;
use Illuminate\Support\ServiceProvider;

class PostsRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind(PostsInterface::class, PostsRepository::class);
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
