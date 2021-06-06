<?php

namespace App\Services;

use App\Interfaces\IProcedureRepository;
use App\Interfaces\IProcedureService;
use Exception;
use Illuminate\Support\Facades\Hash;

class ProcedureService implements IProcedureService
{
    private IProcedureRepository $procedureRepository;

    public function __construct(IProcedureRepository $procedureRepository) {
        $this->procedureRepository = $procedureRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $procedures = $this->procedureRepository->all();

        return $procedures;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $attributes
     * @return \Illuminate\Http\Response
     */
    public function store(Array $data)
    {
        $procedure = $this->procedureRepository->store($data);

        return $procedure;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        if (empty($procedure = $this->procedureRepository->show($id))) {
            throw new Exception('Procedimento informado não existe!');
        }

        return $procedure;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $data
     * @return \Illuminate\Http\Response
     */
    public function update(Array $data, int $id)
    {
        if (empty($this->procedureRepository->show($id))) {
            throw new Exception('Procedimento informado não existe!');
        }

        if (empty($procedure = $this->procedureRepository->update($data, $id))) {
            throw new Exception('Falha ao atualizar o procedimento!');
        }

        return $procedure;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (empty($this->procedureRepository->show($id))) {
            throw new Exception('Procedimento informado não existe!');
        }

        return $this->procedureRepository->destroy($id);
    }
}
