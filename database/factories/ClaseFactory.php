<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'GRP_CODIGO' => $this->faker->numberBetween(1, 5),
            'ARE_CODIGO' => $this->faker->numberBetween(1, 10),
            'PFS_CODIGO' => $this->faker->numberBetween(1, 8)
        ];
    }
}
