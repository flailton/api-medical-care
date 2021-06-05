<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Repositories\UserRepository')
            ->needs('App\Models\User')
            ->give(function () {
                $route = request()->route();

                if ($route && $route->hasParameter('user')) {
                    if($user = User::find($route->parameter('user'))){
                        return $user;
                    }
                }

                return new User();
        });

        $this->app->when('App\Services\UserService')
            ->needs('App\Interfaces\IUserRepository')
            ->give('App\Repositories\UserRepository');

        $this->app->when('App\Http\Controllers\Api\UserController')
            ->needs('App\Interfaces\IUserService')
            ->give('App\Services\UserService');
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
