<?php

namespace App\Services;

use App\Interfaces\IProfessionalRepository;
use App\Interfaces\IProfessionalService;
use Exception;
use Illuminate\Support\Facades\Hash;

class ProfessionalService implements IProfessionalService
{
    private IProfessionalRepository $professionalRepository;

    public function __construct(
        IProfessionalRepository $professionalRepository
    ) {
        $this->professionalRepository = $professionalRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $professionals = $this->professionalRepository->all();

        return $professionals;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $attributes
     * @return \Illuminate\Http\Response
     */
    public function store(Array $data)
    {
        $professional = $this->professionalRepository->store($data);

        return $professional;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Professional  $professional
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        if (empty($professional = $this->professionalRepository->show($id))) {
            throw new Exception('Profissional informado não existe!');
        }

        return $professional;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $data
     * @return \Illuminate\Http\Response
     */
    public function update(Array $data, int $id)
    {
        $attributes = $data;
        if (empty($this->professionalRepository->show($id))) {
            throw new Exception('Profissional informado não existe!');
        }

        if (empty($professional = $this->professionalRepository->update($attributes, $id))) {
            throw new Exception('Falha ao atualizar o profissional!');
        }

        return $professional;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (empty($this->professionalRepository->show($id))) {
            throw new Exception('Profissional informado não existe!');
        }

        return $this->professionalRepository->destroy($id);
    }
}
