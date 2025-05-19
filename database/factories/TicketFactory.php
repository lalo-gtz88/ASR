<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'tema'=> fake()->sentence(),
            'descripcion'=> fake()->sentence(),
            'telefono'=> fake()->randomDigit(10),
            'departamento'=> fake()->name(),
            'status' => 'ABIERTO'
        ];
    }
}
