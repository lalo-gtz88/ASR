<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tickets>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tema' => fake()->sentence(),
            'descripcion' => Str::random(30),
            'telefono' => fake()->phoneNumber(),
            'departamento' => fake()->sentence(),
            'asignado' => rand(1,3),
            'creador' => rand(1,3),
            'prioridad' => 'Media',
            'categoria' => 'Soporte',
            'status' => 'Abierto',
            
        ];
    }
}
