<?php

namespace Database\Factories;

use App\Models\RefHealthIssue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefHealthIssue>
 */
class RefHealthIssueFactory extends Factory
{
    protected $model = RefHealthIssue::class;

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
