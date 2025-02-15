<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NivelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'NIV_NOMBRE' => $this->faker->text(15),
            'NIV_DESCRIPCION' => $this->faker->text(255)
        ];
    }
}
