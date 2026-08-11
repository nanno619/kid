<?php

namespace Database\Factories;

use App\Models\RefLeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<RefLeaveType>
 */
class RefLeaveTypeFactory extends Factory
{
    protected $model = RefLeaveType::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
