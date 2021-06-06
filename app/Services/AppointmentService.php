<?php

namespace App\Services;

use App\Interfaces\IAppointmentRepository;
use App\Interfaces\IAppointmentService;
use Illuminate\Support\Facades\DB;
use Exception;

class AppointmentService implements IAppointmentService
{
    private IAppointmentRepository $appointmentRepository;

    public function __construct(
        IAppointmentRepository $appointmentRepository
    ) {
        $this->appointmentRepository = $appointmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $appointments = $this->appointmentRepository->all();

        foreach ($appointments as $key => $appointment) {
            $appointments[$key]['procedures'] = $appointment->procedures;
        }

        return $appointments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $attributes
     * @return \Illuminate\Http\Response
     */
    public function store(array $data)
    {
        if (empty($data['procedures'])) {
            throw new Exception('É necessário informar ao menos um procedimento!');
        }

        try {
            DB::beginTransaction();

            if (empty($appointment = $this->appointmentRepository->store($data))) {
                throw new Exception('Falha ao criar a consulta!');
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $response['errors'] = $th->getMessage();
            $response['status'] = 406;
        }

        $appointment['procedures'] = $appointment->procedures;

        return $appointment;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        if (empty($appointment = $this->appointmentRepository->show($id))) {
            throw new Exception('Consulta informado não existe!');
        }

        $appointment['procedures'] = $appointment->procedures;

        return $appointment;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $data
     * @return \Illuminate\Http\Response
     */
    public function update(array $data, int $id)
    {
        $attributes = $data;
        if (empty($this->appointmentRepository->show($id))) {
            throw new Exception('Consulta informado não existe!');
        }

        try {
            DB::beginTransaction();
            if (empty($appointment = $this->appointmentRepository->update($attributes, $id))) {
                throw new Exception('Falha ao atualizar o consulta!');
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $response['errors'] = $th->getMessage();
            $response['status'] = 406;
        }

        $appointment['procedures'] = $appointment->procedures;

        return $appointment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (empty($this->appointmentRepository->show($id))) {
            throw new Exception('Consulta informado não existe!');
        }

        return $this->appointmentRepository->destroy($id);
    }
}
