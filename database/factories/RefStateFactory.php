<?php

namespace Database\Factories;

use App\Models\RefCountry;
use App\Models\RefState;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefState>
 */
class RefStateFactory extends Factory
{
    protected $model = RefState::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->state(),
            'country_id' => RefCountry::factory(),
        ];
    }
}
