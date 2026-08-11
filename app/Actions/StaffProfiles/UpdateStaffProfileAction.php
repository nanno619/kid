<?php

namespace App\Actions\StaffProfiles;

use App\DataTransferObjects\AddressData;
use App\DataTransferObjects\StaffProfileData;
use App\Models\StaffProfile;

final class UpdateStaffProfileAction
{
    public function __invoke(StaffProfile $staffProfile, StaffProfileData $data, AddressData $addressData): StaffProfile
    {
        $staffProfile->update($data->toArray());

        $staffProfile->address()->updateOrCreate([], $addressData->toArray());

        return $staffProfile->fresh();
    }
}
