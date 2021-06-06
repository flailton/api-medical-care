<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Interfaces\IAppointmentRepository;

class AppointmentRepository implements IAppointmentRepository
{
    private Appointment $appointment;

    public function __construct(Appointment $appointment) {
        $this->appointment = $appointment;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->appointment->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Models\Appointment
     */
    public function store($attributes)
    {
        $appointment = $this->appointment->create($attributes);

        $appointment->procedures()->detach();
        $appointment->procedures()->attach($attributes['procedures']);
        
        return $appointment;
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Models\Appointment
     */
    public function show($id)
    {
        return $this->appointment->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $attributes
     * @return \App\Models\Appointment
     */
    public function update($attributes, $id)
    {
        $appointment = $this->appointment->find($id);
        $appointment->update($attributes);

        $appointment->procedures()->detach();
        $appointment->procedures()->attach($attributes['procedures']);
        
        return $appointment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = $this->appointment->find($id);
        $appointment->delete();

        return $appointment;
    }
}