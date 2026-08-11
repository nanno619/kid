<?php

use App\Actions\StaffProfiles\UpdateStaffProfileAction;
use App\DataTransferObjects\AddressData;
use App\DataTransferObjects\StaffProfileData;
use App\Models\RefBank;
use App\Models\RefDepartment;
use App\Models\RefGender;
use App\Models\RefMaritalStatus;
use App\Models\RefRace;
use App\Models\RefReligion;
use App\Models\RefState;
use App\Models\StaffProfile;

function makeStaffProfileData(array $overrides = []): StaffProfileData
{
    return new StaffProfileData(
        staffNumber: $overrides['staffNumber'] ?? 'STF-9999',
        fullName: 'Jane Doe',
        icNumber: '900101-14-1234',
        dateOfBirth: '1990-01-01',
        genderId: RefGender::factory()->create()->id,
        raceId: RefRace::factory()->create()->id,
        religionId: RefReligion::factory()->create()->id,
        maritalStatusId: RefMaritalStatus::factory()->create()->id,
        mobileNumber: '012-3456789',
        siblingsCount: 2,
        educationLevel: 'Diploma',
        ambition: 'Teacher',
        fieldExperience: null,
        previousWorkExperience: null,
        reasonLeftPreviousJob: null,
        hasMentalIllness: false,
        illnessDetails: null,
        familyMemberName: null,
        familyMemberIc: null,
        familyMemberOccupation: null,
        familyMemberEmployerAddress: null,
        familyMemberPhone: null,
        epfNumber: $overrides['epfNumber'] ?? 'EPF1234567',
        departmentId: $overrides['departmentId'] ?? RefDepartment::factory()->create()->id,
        bankId: $overrides['bankId'] ?? RefBank::factory()->create()->id,
        bankAccountNumber: $overrides['bankAccountNumber'] ?? '123456789012',
    );
}

test('it updates the staff profile and upserts the address', function () {
    $staffProfile = StaffProfile::factory()->create();
    $data = makeStaffProfileData();
    $addressData = new AddressData(
        addressLine1: '123 Jalan Test',
        addressLine2: null,
        addressLine3: null,
        stateId: RefState::factory()->create()->id,
        district: 'Petaling',
        city: 'Shah Alam',
        postcode: '40000',
    );

    $result = (new UpdateStaffProfileAction)($staffProfile, $data, $addressData);

    expect($result->full_name)->toBe('Jane Doe')
        ->and($result->address->address_line_1)->toBe('123 Jalan Test');
});

test('it updates the existing address instead of creating a second one', function () {
    $staffProfile = StaffProfile::factory()->create();
    $staffProfile->address()->create(['address_line_1' => 'Old Address']);

    $addressData = new AddressData(
        addressLine1: 'New Address',
        addressLine2: null,
        addressLine3: null,
        stateId: null,
        district: null,
        city: null,
        postcode: null,
    );

    (new UpdateStaffProfileAction)($staffProfile, makeStaffProfileData(), $addressData);

    expect($staffProfile->fresh()->address->address_line_1)->toBe('New Address')
        ->and($staffProfile->fresh()->address()->count())->toBe(1);
});
