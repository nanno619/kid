<?php

use App\Models\StaffProfile;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('a teacher cannot mount the table', function () {
    $teacher = User::factory()->create()->assignRole('teacher');

    Livewire::actingAs($teacher)
        ->test('staff-profiles-table')
        ->assertForbidden();
});

test('a principal can mount the table and sees all staff profiles', function () {
    $principal = User::factory()->create()->assignRole('principal');
    StaffProfile::factory()->create(['full_name' => 'Jane Doe']);
    StaffProfile::factory()->create(['full_name' => 'John Smith']);

    Livewire::actingAs($principal)
        ->test('staff-profiles-table')
        ->assertSee('Jane Doe')
        ->assertSee('John Smith');
});

test('search filters the list by name or ic number', function () {
    $principal = User::factory()->create()->assignRole('principal');
    StaffProfile::factory()->create(['full_name' => 'Jane Doe', 'ic_number' => '900101-14-1111']);
    StaffProfile::factory()->create(['full_name' => 'John Smith', 'ic_number' => '900101-14-2222']);

    Livewire::actingAs($principal)
        ->test('staff-profiles-table')
        ->set('search', 'Jane')
        ->assertSee('Jane Doe')
        ->assertDontSee('John Smith');
});

test('searching resets the page back to 1', function () {
    $principal = User::factory()->create()->assignRole('principal');
    StaffProfile::factory()->count(20)->create();
    StaffProfile::factory()->create(['full_name' => 'Findable Person']);

    Livewire::actingAs($principal)
        ->test('staff-profiles-table')
        ->call('setPage', 2)
        ->set('search', 'Findable')
        ->assertSee('Findable Person');
});

test('sortBy toggles direction when clicking the same column twice', function () {
    $principal = User::factory()->create()->assignRole('principal');

    Livewire::actingAs($principal)
        ->test('staff-profiles-table')
        ->assertSet('sortColumn', 'full_name')
        ->assertSet('sortDirection', 'asc')
        ->call('sortBy', 'full_name')
        ->assertSet('sortDirection', 'desc')
        ->call('sortBy', 'full_name')
        ->assertSet('sortDirection', 'asc')
        ->call('sortBy', 'ic_number')
        ->assertSet('sortColumn', 'ic_number')
        ->assertSet('sortDirection', 'asc');
});

test('the list is paginated at 15 per page', function () {
    $principal = User::factory()->create()->assignRole('principal');
    StaffProfile::factory()->sequence(fn ($sequence) => ['full_name' => 'Staff Member '.str_pad((string) ($sequence->index + 1), 2, '0', STR_PAD_LEFT)])
        ->count(20)
        ->create();

    Livewire::actingAs($principal)
        ->test('staff-profiles-table')
        ->set('sortColumn', 'full_name')
        ->assertSee('Staff Member 01')
        ->assertDontSee('Staff Member 20')
        ->call('nextPage')
        ->assertSee('Staff Member 20');
});
