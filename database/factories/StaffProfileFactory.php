<?php

namespace Database\Factories;

use App\Models\RefBank;
use App\Models\RefDepartment;
use App\Models\RefGender;
use App\Models\RefMaritalStatus;
use App\Models\RefRace;
use App\Models\RefReligion;
use App\Models\StaffProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StaffProfile>
 */
class StaffProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'staff_number' => fake()->unique()->numerify('STF-####'),
            'full_name' => fake()->name(),
            'ic_number' => fake()->numerify('##########'),
            'date_of_birth' => fake()->dateTimeBetween('-55 years', '-20 years'),
            'gender_id' => RefGender::factory(),
            'race_id' => RefRace::factory(),
            'religion_id' => RefReligion::factory(),
            'marital_status_id' => RefMaritalStatus::factory(),
            'mobile_number' => fake()->phoneNumber(),
            'epf_number' => fake()->numerify('EPF#######'),
            'department_id' => RefDepartment::factory(),
            'bank_id' => RefBank::factory(),
            'bank_account_number' => fake()->numerify('############'),
        ];
    }
}
