<?php

namespace Database\Factories;

use App\Models\RefIllness;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefIllness>
 */
class RefIllnessFactory extends Factory
{
    protected $model = RefIllness::class;

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
