<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Procedure;

class ProcedureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Repositories\ProcedureRepository')
            ->needs('App\Models\Procedure')
            ->give(function () {
                return new Procedure();
            });

        $this->app->when('App\Services\ProcedureService')
            ->needs('App\Interfaces\IProcedureRepository')
            ->give('App\Repositories\ProcedureRepository');

        $this->app->when('App\Http\Controllers\Api\ProcedureController')
            ->needs('App\Interfaces\IProcedureService')
            ->give('App\Services\ProcedureService');
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
