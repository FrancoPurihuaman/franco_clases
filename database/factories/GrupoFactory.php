<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GrupoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'GRP_SECCION' => $this->faker->text(5),
            'GRP_TIPO_PERIODO' => $this->faker->randomElement([
                'TRIMESTE',
                'BIIMESTRE',
                'MENSUAL'
            ]),
            'GRP_TOTAL_PERIODOS' => 3,
            'GRP_PERIODO_ACTUAL' => 1,
            'GRP_FECHA_INICIO' => '2025-03-06',
            'GRP_FECHA_CIERRE' => '2025-12-31',
            'GRP_ESTADO' => $this->faker->randomElement([0,1]),
            'NIV_CODIGO' => $this->faker->numberBetween(1,5)
        ];
    }
}
