<?php

namespace Database\Seeders;

use App\Models\RefBank;
use App\Models\RefCountry;
use App\Models\RefDepartment;
use App\Models\RefGender;
use App\Models\RefHealthIssue;
use App\Models\RefIllness;
use App\Models\RefLeaveType;
use App\Models\RefMaritalStatus;
use App\Models\RefRace;
use App\Models\RefReligion;
use App\Models\RefState;
use Illuminate\Database\Seeder;

class RefDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedGenders();
        $this->seedReligions();
        $this->seedRaces();
        $this->seedMaritalStatuses();
        $this->seedDepartments();
        $this->seedLeaveTypes();
        $this->seedIllnesses();
        $this->seedHealthIssues();
        $this->seedBanks();
        $this->seedCountriesAndStates();
    }

    private function seedGenders(): void
    {
        collect(['Lelaki', 'Perempuan'])
            ->each(fn (string $name) => RefGender::firstOrCreate(['name' => $name]));
    }

    private function seedReligions(): void
    {
        collect(['Islam', 'Kristian', 'Buddha', 'Hindu', 'Lain-lain'])
            ->each(fn (string $name) => RefReligion::firstOrCreate(['name' => $name]));
    }

    private function seedRaces(): void
    {
        collect(['Melayu', 'Cina', 'India', 'Bumiputera Sabah/Sarawak', 'Lain-lain'])
            ->each(fn (string $name) => RefRace::firstOrCreate(['name' => $name]));
    }

    private function seedMaritalStatuses(): void
    {
        collect(['Bujang', 'Berkahwin', 'Bercerai', 'Balu/Duda'])
            ->each(fn (string $name) => RefMaritalStatus::firstOrCreate(['name' => $name]));
    }

    private function seedDepartments(): void
    {
        // Open-ended per Backend Schema — starts with the two values from the leave form's Bahagian field.
        collect(['Playschool', 'Babyschool'])
            ->each(fn (string $name) => RefDepartment::firstOrCreate(['name' => $name]));
    }

    private function seedLeaveTypes(): void
    {
        // Exactly the six types from the paper leave application form.
        // `cuti-tahunan` slug is how leave_balances identifies the type that draws down the 8-day quota.
        collect([
            ['name' => 'Cuti Tahunan', 'slug' => 'cuti-tahunan'],
            ['name' => 'Cuti Kecemasan', 'slug' => 'cuti-kecemasan'],
            ['name' => 'Cuti Tanpa Gaji', 'slug' => 'cuti-tanpa-gaji'],
            ['name' => 'Cuti Ganti', 'slug' => 'cuti-ganti'],
            ['name' => 'Cuti Sakit', 'slug' => 'cuti-sakit'],
            ['name' => 'Cuti Lain-lain', 'slug' => 'cuti-lain-lain'],
        ])->each(fn (array $type) => RefLeaveType::firstOrCreate(['slug' => $type['slug']], $type));
    }

    private function seedIllnesses(): void
    {
        // Exactly the checkboxes from the children registration form, Section C.
        collect(['Lelah', 'Batuk Kering', 'Sakit Jantung', 'Gastrik', 'Barah', 'Sawan', 'Lain-lain'])
            ->each(fn (string $name) => RefIllness::firstOrCreate(['name' => $name]));
    }

    private function seedHealthIssues(): void
    {
        // Exactly the checkboxes from the children registration form, Section C.
        collect([
            'Cepat Penat',
            'Sakit Dada',
            'Selalu Pitam/Pening Kepala',
            'Kurang Penglihatan',
            'Kurang Pendengaran',
            'Alahan',
            'Lain-lain',
        ])->each(fn (string $name) => RefHealthIssue::firstOrCreate(['name' => $name]));
    }

    private function seedBanks(): void
    {
        collect([
            'Maybank', 'CIMB Bank', 'Public Bank', 'RHB Bank', 'Hong Leong Bank',
            'AmBank', 'Bank Islam', 'Bank Rakyat', 'BSN', 'Affin Bank',
            'Alliance Bank', 'UOB', 'OCBC', 'HSBC', 'Standard Chartered',
        ])->each(fn (string $name) => RefBank::firstOrCreate(['name' => $name]));
    }

    private function seedCountriesAndStates(): void
    {
        $malaysia = RefCountry::firstOrCreate(['name' => 'Malaysia']);

        collect([
            'Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang',
            'Perak', 'Perlis', 'Pulau Pinang', 'Sabah', 'Sarawak', 'Selangor',
            'Terengganu', 'WP Kuala Lumpur', 'WP Labuan', 'WP Putrajaya',
        ])->each(fn (string $name) => RefState::firstOrCreate([
            'country_id' => $malaysia->id,
            'name' => $name,
        ]));

        // Starter list — open-ended per Backend Schema, principal can manage the full list later.
        collect([
            'Singapore', 'Indonesia', 'Thailand', 'Brunei', 'Philippines', 'Vietnam',
            'Cambodia', 'Laos', 'Myanmar', 'China', 'India', 'Pakistan', 'Bangladesh',
            'Nepal', 'Sri Lanka', 'Japan', 'South Korea', 'United Kingdom',
            'United States', 'Australia', 'New Zealand', 'Canada',
        ])->each(fn (string $name) => RefCountry::firstOrCreate(['name' => $name]));
    }
}
