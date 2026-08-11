<?php

namespace Database\Factories;

use App\Models\RefReligion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefReligion>
 */
class RefReligionFactory extends Factory
{
    protected $model = RefReligion::class;

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
