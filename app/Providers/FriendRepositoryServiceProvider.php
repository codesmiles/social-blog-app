<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\FriendsInterface;
use App\Repository\FriendsRepository;

class FriendRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FriendsInterface::class, FriendsRepository::class);
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
