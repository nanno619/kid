<?php

use App\Models\StaffProfile;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('principal can view and update any staff profile', function () {
    $principal = User::factory()->create()->assignRole('principal');
    $someonesProfile = StaffProfile::factory()->create();

    expect($principal->can('view', $someonesProfile))->toBeTrue()
        ->and($principal->can('update', $someonesProfile))->toBeTrue()
        ->and($principal->can('viewAny', StaffProfile::class))->toBeTrue();
});

test('admin can view and update any staff profile', function () {
    $admin = User::factory()->create()->assignRole('admin');
    $someonesProfile = StaffProfile::factory()->create();

    expect($admin->can('view', $someonesProfile))->toBeTrue()
        ->and($admin->can('update', $someonesProfile))->toBeTrue()
        ->and($admin->can('viewAny', StaffProfile::class))->toBeTrue();
});

test('teacher can view and update only their own staff profile', function () {
    $teacher = User::factory()->create()->assignRole('teacher');
    $ownProfile = StaffProfile::factory()->for($teacher)->create();
    $othersProfile = StaffProfile::factory()->create();

    expect($teacher->can('view', $ownProfile))->toBeTrue()
        ->and($teacher->can('update', $ownProfile))->toBeTrue()
        ->and($teacher->can('view', $othersProfile))->toBeFalse()
        ->and($teacher->can('update', $othersProfile))->toBeFalse()
        ->and($teacher->can('viewAny', StaffProfile::class))->toBeFalse();
});
