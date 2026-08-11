<?php

use App\Models\User;
use Illuminate\Notifications\Notification;

test('a database notification can be sent and appears on the recipient', function () {
    $user = User::factory()->create();

    $notification = new class extends Notification
    {
        public function via(object $notifiable): array
        {
            return ['database'];
        }

        public function toArray(object $notifiable): array
        {
            return ['message' => 'Phase 0 wiring check'];
        }
    };

    $user->notify($notification);

    expect($user->notifications()->count())->toBe(1)
        ->and($user->unreadNotifications()->count())->toBe(1)
        ->and($user->notifications()->first()->data['message'])->toBe('Phase 0 wiring check');
});
