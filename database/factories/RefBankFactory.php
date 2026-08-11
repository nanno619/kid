<?php

namespace Database\Factories;

use App\Models\RefBank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefBank>
 */
class RefBankFactory extends Factory
{
    protected $model = RefBank::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
        ];
    }
}
