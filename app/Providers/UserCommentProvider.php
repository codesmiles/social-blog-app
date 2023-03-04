<?php

namespace App\Providers;

use App\Interfaces\CommentInterface;
use App\Repository\CommentRepository;
use Illuminate\Support\ServiceProvider;

class UserCommentProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CommentInterface::class, CommentRepository::class);

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
