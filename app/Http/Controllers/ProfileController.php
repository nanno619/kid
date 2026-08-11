<?php

namespace App\Http\Controllers;

use App\Actions\StaffProfiles\UpdateStaffProfileAction;
use App\DataTransferObjects\AddressData;
use App\DataTransferObjects\StaffProfileData;
use App\Http\Requests\StoreStaffProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\View;

#[Middleware('auth')]
class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit', [
            'staffProfile' => auth()->user()->staffProfile,
        ]);
    }

    public function update(StoreStaffProfileRequest $request, UpdateStaffProfileAction $action): RedirectResponse
    {
        $staffProfile = auth()->user()->staffProfile;

        $data = StaffProfileData::fromRequest($request)->withAdminFieldsFrom($staffProfile);
        $addressData = AddressData::fromRequest($request);

        $action($staffProfile, $data, $addressData);

        return redirect()->route('profile.edit')->with('status', 'Profile updated.');
    }
}
