<?php

namespace Database\Factories;

use App\Models\Procedure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProcedureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Procedure::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $digits ="0123456789";
        return [
            'name' => 'Procedure ' . substr(str_shuffle($digits), 0, 2),
            'description' => $this->faker->text,
            'value' => rand(0, 500), 
            'percent' => rand(0, 100) / 100
        ];
    }
}
