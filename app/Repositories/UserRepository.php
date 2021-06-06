<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\IUserRepository;

class UserRepository implements IUserRepository
{
    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->user->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Models\User
     */
    public function store($attributes)
    {
        return $this->user->create($attributes);
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Models\User
     */
    public function show($id)
    {
        return $this->user->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $attributes
     * @return \App\Models\User
     */
    public function update($attributes, $id)
    {
        $user = $this->user->find($id);
        $user->update($attributes);
        
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);
        $user->delete();

        return $user;
    }
}