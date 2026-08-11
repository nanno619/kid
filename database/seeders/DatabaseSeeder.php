<?php

namespace Database\Seeders;

use App\Models\RefBank;
use App\Models\RefDepartment;
use App\Models\RefGender;
use App\Models\RefMaritalStatus;
use App\Models\RefRace;
use App\Models\RefReligion;
use App\Models\RefState;
use App\Models\StaffProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            RefDataSeeder::class,
        ]);

        $principal = User::factory()->create([
            'name' => 'Test User',
            'short_name' => 'Test',
            'email' => 'test@example.com',
        ]);
        $principal->assignRole('principal');
        $this->seedStaffProfile($principal, 'STF-0001');

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'short_name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');
        $this->seedStaffProfile($admin, 'STF-0002');
    }

    private function seedStaffProfile(User $user, string $staffNumber): void
    {
        $staffProfile = StaffProfile::create([
            'user_id' => $user->id,
            'staff_number' => $staffNumber,
            'full_name' => strtoupper($user->name),
            'ic_number' => '900101-14-'.fake()->numerify('####'),
            'date_of_birth' => '1990-01-01',
            'gender_id' => RefGender::where('name', 'Lelaki')->firstOrFail()->id,
            'race_id' => RefRace::where('name', 'Melayu')->firstOrFail()->id,
            'religion_id' => RefReligion::where('name', 'Islam')->firstOrFail()->id,
            'marital_status_id' => RefMaritalStatus::where('name', 'Berkahwin')->firstOrFail()->id,
            'mobile_number' => '012-3456789',
            'epf_number' => 'EPF'.fake()->numerify('#######'),
            'department_id' => RefDepartment::where('name', 'Playschool')->firstOrFail()->id,
            'bank_id' => RefBank::where('name', 'Maybank')->firstOrFail()->id,
            'bank_account_number' => fake()->numerify('############'),
        ]);

        $staffProfile->address()->create([
            'address_line_1' => fake()->streetAddress(),
            'state_id' => RefState::where('name', 'Selangor')->firstOrFail()->id,
            'district' => 'Petaling',
            'city' => 'Shah Alam',
            'postcode' => '40000',
        ]);
    }
}
