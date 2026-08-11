<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Admin's day-to-day data-entry permissions (per TDD's Admin breakdown).
     * Principal gets these too, on top of its own approval-only permissions.
     *
     * @var array<int, string>
     */
    private const ADMIN_PERMISSIONS = [
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
    ];

    /**
     * Principal's final-approval-authority permissions (per TDD's Principal breakdown).
     *
     * @var array<int, string>
     */
    private const PRINCIPAL_ONLY_PERMISSIONS = [
        'children.approve',
        'children.return',
        'job-applications.approve',
        'job-applications.reject',
        'leave-applications.approve',
        'leave-applications.reject',
        'payslips.publish',
        'payslips.return',
    ];

    /**
     * Teacher's narrow, own-record-only permissions (per TDD's Teacher breakdown).
     *
     * @var array<int, string>
     */
    private const TEACHER_PERMISSIONS = [
        'staff-profiles.view-own',
        'staff-profiles.edit-own',
        'leave-applications.create',
        'payslips.view-own',
    ];

    public function run(): void
    {
        collect([...self::ADMIN_PERMISSIONS, ...self::PRINCIPAL_ONLY_PERMISSIONS, ...self::TEACHER_PERMISSIONS])
            ->unique()
            ->each(fn (string $permission) => Permission::firstOrCreate(['name' => $permission]));

        Role::firstOrCreate(['name' => 'admin'])
            ->syncPermissions(self::ADMIN_PERMISSIONS);

        Role::firstOrCreate(['name' => 'principal'])
            ->syncPermissions([...self::ADMIN_PERMISSIONS, ...self::PRINCIPAL_ONLY_PERMISSIONS]);

        Role::firstOrCreate(['name' => 'teacher'])
            ->syncPermissions(self::TEACHER_PERMISSIONS);
    }
}
