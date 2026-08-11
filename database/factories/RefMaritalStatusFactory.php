<?php

namespace Database\Factories;

use App\Models\RefMaritalStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefMaritalStatus>
 */
class RefMaritalStatusFactory extends Factory
{
    protected $model = RefMaritalStatus::class;

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
