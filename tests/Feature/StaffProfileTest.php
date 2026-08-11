<?php

use App\Models\StaffProfile;
use App\Models\User;

test('a user has one staff profile', function () {
    $user = User::factory()->create();
    $staffProfile = StaffProfile::factory()->for($user)->create();

    expect($user->fresh()->staffProfile->is($staffProfile))->toBeTrue()
        ->and($staffProfile->ulid)->not->toBeNull();
});

test('a staff profile can have an address via the polymorphic relation', function () {
    $staffProfile = StaffProfile::factory()->create();

    $address = $staffProfile->address()->create([
        'address_line_1' => '123 Jalan Test',
        'district' => 'Petaling',
        'city' => 'Shah Alam',
        'postcode' => '40000',
    ]);

    expect($staffProfile->fresh()->address->is($address))->toBeTrue();
});
