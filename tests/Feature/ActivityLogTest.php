<?php

use App\Models\User;
use Spatie\Activitylog\Models\Activity;

test('an activity can be logged with a causer', function () {
    $user = User::factory()->create();

    activity()->causedBy($user)->log('Phase 0 wiring check');

    expect(Activity::count())->toBe(1)
        ->and(Activity::first()->causer->is($user))->toBeTrue()
        ->and(Activity::first()->description)->toBe('Phase 0 wiring check');
});
