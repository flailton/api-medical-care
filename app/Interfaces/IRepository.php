<?php

namespace App\Interfaces;

interface IRepository
{
    public function all();

    public function store(Array $attributes);

    public function show(int $id);

    public function update(Array $attributes, int $id);
    
    public function destroy(int $id);
}