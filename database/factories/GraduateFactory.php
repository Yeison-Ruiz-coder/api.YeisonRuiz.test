<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Graduate>
 */
class GraduateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName(),
            'fecha_nacimiento' => $this->faker->date(),
            'telefono' => $this->faker->phoneNumber(),
            'direccion' => $this->faker->address(),
            'correo' => $this->faker->safeEmail(),
            'nombre_FB' => $this->faker->word(),

            'city_id' => \App\Models\City::factory()
        ];
    }
}
