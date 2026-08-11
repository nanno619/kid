<?php

namespace Database\Factories;

use App\Models\RefCountry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefCountry>
 */
class RefCountryFactory extends Factory
{
    protected $model = RefCountry::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->country(),
        ];
    }
}
