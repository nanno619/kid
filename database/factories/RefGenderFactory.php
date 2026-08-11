<?php

namespace Database\Factories;

use App\Models\RefGender;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefGender>
 */
class RefGenderFactory extends Factory
{
    protected $model = RefGender::class;

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
