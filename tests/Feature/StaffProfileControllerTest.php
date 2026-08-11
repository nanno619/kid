<?php

use App\Models\StaffProfile;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('a principal can view the staff profiles list', function () {
    $principal = User::factory()->create()->assignRole('principal');
    StaffProfile::factory()->count(2)->create();

    $this->actingAs($principal)->get('/staff-profiles')->assertSuccessful();
});

test('an admin can view the staff profiles list', function () {
    $admin = User::factory()->create()->assignRole('admin');

    $this->actingAs($admin)->get('/staff-profiles')->assertSuccessful();
});

test('a teacher cannot view the staff profiles list', function () {
    $teacher = User::factory()->create()->assignRole('teacher');

    $this->actingAs($teacher)->get('/staff-profiles')->assertForbidden();
});

test('a principal can edit any staff profile, including admin-managed fields', function () {
    $principal = User::factory()->create()->assignRole('principal');
    $staffProfile = StaffProfile::factory()->create(['staff_number' => 'STF-OLD']);

    $this->actingAs($principal)
        ->put(route('staff-profiles.update', $staffProfile), validStaffProfilePayload([
            'staff_number' => 'STF-NEW',
        ]))
        ->assertRedirect(route('staff-profiles.edit', $staffProfile));

    expect($staffProfile->fresh()->staff_number)->toBe('STF-NEW');
});

test('a teacher cannot edit another staff member\'s profile', function () {
    $teacher = User::factory()->create()->assignRole('teacher');
    $othersProfile = StaffProfile::factory()->create();

    $this->actingAs($teacher)
        ->put(route('staff-profiles.update', $othersProfile), validStaffProfilePayload())
        ->assertForbidden();
});
