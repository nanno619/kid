<?php

use App\Models\Address;
use App\Models\User;

test('an address can be attached to any model via the polymorphic relation', function () {
    $user = User::factory()->create();

    $address = Address::factory()->for($user, 'addressable')->create();

    expect($address->ulid)->not->toBeNull()
        ->and($address->addressable->is($user))->toBeTrue()
        ->and(Address::where('addressable_type', User::class)->where('addressable_id', $user->id)->exists())->toBeTrue();
});
