<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CalificacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'CLF_TIPO' => $this->faker->randomElement([
                'PRACTICA',
                'TRABAJO',
                'ASISTENCIA'
            ]),
            'CLF_NRO_PERIODO' => 1,
            'CLF_FECHA' => $this->faker->date(),
            'CLF_NOTA' => $this->faker->randomElement(['AD', 'A', 'B', 'C']),
            'CLF_DESCRIPCION' => $this->faker->text(50),
            'STD_CODIGO' => $this->faker->numberBetween(1, 49),
            'CLS_CODIGO' => $this->faker->numberBetween(1, 2),
            'CPT_CODIGO' => $this->faker->numberBetween(1, 2)
        ];
    }
}
