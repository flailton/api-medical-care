<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Appointment;

class AppointmentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when('App\Repositories\AppointmentRepository')
            ->needs('App\Models\Appointment')
            ->give(function () {
                return new Appointment();
            });

        $this->app->when('App\Services\AppointmentService')
            ->needs('App\Interfaces\IAppointmentRepository')
            ->give('App\Repositories\AppointmentRepository');

        $this->app->when('App\Http\Controllers\Api\AppointmentController')
            ->needs('App\Interfaces\IAppointmentService')
            ->give('App\Services\AppointmentService');
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
