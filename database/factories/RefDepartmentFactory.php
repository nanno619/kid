<?php

namespace Database\Factories;

use App\Models\RefDepartment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefDepartment>
 */
class RefDepartmentFactory extends Factory
{
    protected $model = RefDepartment::class;

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
