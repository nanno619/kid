<?php

use App\Models\RefLeaveType;
use App\Models\RefState;
use Database\Seeders\RefDataSeeder;

test('ref_leave_types has a cuti-tahunan slug', function () {
    $this->seed(RefDataSeeder::class);

    expect(RefLeaveType::where('slug', 'cuti-tahunan')->exists())->toBeTrue();
});

test('ref_leave_types has exactly the six leave types from the paper form', function () {
    $this->seed(RefDataSeeder::class);

    expect(RefLeaveType::count())->toBe(6);
});

test('ref_states are linked to Malaysia', function () {
    $this->seed(RefDataSeeder::class);

    $selangor = RefState::where('name', 'Selangor')->first();

    expect($selangor)->not->toBeNull()
        ->and($selangor->country->name)->toBe('Malaysia');
});

test('seeding the ref data is idempotent', function () {
    $this->seed(RefDataSeeder::class);
    $leaveTypeCountAfterFirstSeed = RefLeaveType::count();

    $this->seed(RefDataSeeder::class);

    expect(RefLeaveType::count())->toBe($leaveTypeCountAfterFirstSeed);
});
