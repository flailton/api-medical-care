<?php

namespace App\Repositories;

use App\Models\Professional;
use App\Interfaces\IProfessionalRepository;

class ProfessionalRepository implements IProfessionalRepository
{
    private Professional $professional;

    public function __construct(Professional $professional) {
        $this->professional = $professional;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->professional->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Models\Professional
     */
    public function store($attributes)
    {
        return $this->professional->create($attributes);
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Models\Professional
     */
    public function show($id)
    {
        return $this->professional->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $attributes
     * @return \App\Models\Professional
     */
    public function update($attributes, $id)
    {
        $professional = $this->professional->find($id);
        $professional->update($attributes);
        
        return $professional;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Professional  $Professional
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $professional = $this->professional->find($id);
        $professional->delete();

        return $professional;
    }
}