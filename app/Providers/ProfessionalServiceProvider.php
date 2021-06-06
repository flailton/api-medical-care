<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Professional;

class ProfessionalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Repositories\ProfessionalRepository')
            ->needs('App\Models\Professional')
            ->give(function () {
                return new Professional();
            });

        $this->app->when('App\Services\ProfessionalService')
            ->needs('App\Interfaces\IProfessionalRepository')
            ->give('App\Repositories\ProfessionalRepository');

        $this->app->when('App\Http\Controllers\Api\ProfessionalController')
            ->needs('App\Interfaces\IProfessionalService')
            ->give('App\Services\ProfessionalService');
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
