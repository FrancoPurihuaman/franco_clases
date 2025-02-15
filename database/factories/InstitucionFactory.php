<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InstitucionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ITC_CODIGO_MODULAR'    => '1352400',
            'ITC_NOMBRE'            => 'ARUTAM',
            'ITC_DIRECTOR'          => 'Galdino Ordoñes Pallano',
        ];
    }
}
