<?php

use Database\Seeders\RolePermissionSeeder;
use Spatie\Permission\Models\Role;

test('admin has exactly the permissions listed in the TDD', function () {
    $this->seed(RolePermissionSeeder::class);

    $permissions = Role::findByName('admin')->permissions->pluck('name')->sort()->values();

    expect($permissions->all())->toEqualCanonicalizing([
        'children.create',
        'children.edit',
        'children.submit',
        'staff-profiles.view',
        'staff-profiles.edit',
        'job-applications.view',
        'leave-applications.view',
        'payslips.create',
        'payslips.edit',
        'payslips.submit',
    ]);
});

test('principal has admin permissions plus final approval authority', function () {
    $this->seed(RolePermissionSeeder::class);

    $permissions = Role::findByName('principal')->permissions->pluck('name');

    expect($permissions->all())->toEqualCanonicalizing([
        'children.create',
        'children.edit',
        'children.submit',
        'children.approve',
        'children.return',
        'staff-profiles.view',
        'staff-profiles.edit',
        'job-applications.view',
        'job-applications.approve',
        'job-applications.reject',
        'leave-applications.view',
        'leave-applications.approve',
        'leave-applications.reject',
        'payslips.create',
        'payslips.edit',
        'payslips.submit',
        'payslips.publish',
        'payslips.return',
    ]);
});

test('teacher has only its own narrow, own-record permissions', function () {
    $this->seed(RolePermissionSeeder::class);

    $permissions = Role::findByName('teacher')->permissions->pluck('name');

    expect($permissions->all())->toEqualCanonicalizing([
        'staff-profiles.view-own',
        'staff-profiles.edit-own',
        'leave-applications.create',
        'payslips.view-own',
    ]);
});

test('seeding the roles is idempotent', function () {
    $this->seed(RolePermissionSeeder::class);
    $this->seed(RolePermissionSeeder::class);

    expect(Role::count())->toBe(3);
});
