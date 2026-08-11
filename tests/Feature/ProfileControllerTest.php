<?php

use App\Models\RefDepartment;
use App\Models\StaffProfile;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('a teacher can view their own profile edit page', function () {
    $teacher = User::factory()->create()->assignRole('teacher');
    StaffProfile::factory()->for($teacher)->create();

    $this->actingAs($teacher)->get('/profile')->assertSuccessful();
});

test('a teacher can update their own profile', function () {
    $teacher = User::factory()->create()->assignRole('teacher');
    $staffProfile = StaffProfile::factory()->for($teacher)->create();

    $this->actingAs($teacher)
        ->put('/profile', validStaffProfilePayload(['full_name' => 'Updated Name']))
        ->assertRedirect(route('profile.edit'));

    expect($staffProfile->fresh()->full_name)->toBe('Updated Name');
});

test('a teacher cannot change admin-managed fields on their own profile', function () {
    $teacher = User::factory()->create()->assignRole('teacher');
    $staffProfile = StaffProfile::factory()->for($teacher)->create([
        'staff_number' => 'STF-ORIGINAL',
        'department_id' => RefDepartment::factory()->create()->id,
    ]);
    $originalDepartmentId = $staffProfile->department_id;

    $this->actingAs($teacher)->put('/profile', validStaffProfilePayload([
        'staff_number' => 'STF-HACKED',
    ]));

    expect($staffProfile->fresh()->staff_number)->toBe('STF-ORIGINAL')
        ->and($staffProfile->fresh()->department_id)->toBe($originalDepartmentId);
});

test('guests are redirected to login', function () {
    $this->get('/profile')->assertRedirect('/login');
});
