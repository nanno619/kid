<?php

namespace Database\Factories;

use App\Models\RefRace;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefRace>
 */
class RefRaceFactory extends Factory
{
    protected $model = RefRace::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
        ];
    }
}
