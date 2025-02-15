<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MatriculaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'MTL_TUTOR' => 'Tutor test',
            'GRP_CODIGO' => $this->faker->numberBetween(1, 2),
            'STD_CODIGO' => $this->faker->numberBetween(1, 50)
        ];
    }
}
