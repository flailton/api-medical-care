<?php

namespace App\Repositories;

use App\Models\Procedure;
use App\Interfaces\IProcedureRepository;

class ProcedureRepository implements IProcedureRepository
{
    private Procedure $procedure;

    public function __construct(Procedure $procedure) {
        $this->procedure = $procedure;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->procedure->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Models\Procedure
     */
    public function store($attributes)
    {
        return $this->procedure->create($attributes);
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Models\Procedure
     */
    public function show($id)
    {
        return $this->procedure->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $attributes
     * @return \App\Models\Procedure
     */
    public function update($attributes, $id)
    {
        $procedure = $this->procedure->find($id);
        $procedure->update($attributes);
        
        return $procedure;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $procedure = $this->procedure->find($id);
        $procedure->delete();

        return $procedure;
    }
}