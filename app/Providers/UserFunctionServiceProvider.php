<?php

namespace App\Providers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class UserFunctionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register($modelName, $arr)
    {
        // // check if the password is provided in the request
        // if (request()->has('password')) {
        //     $arr['password'] = Hash::make(request()->password);
        // }
        // create the user
        $data = $modelName::create($arr);

        return $data;
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