<?php

namespace App\Http\Controllers;

use App\Actions\StaffProfiles\UpdateStaffProfileAction;
use App\DataTransferObjects\AddressData;
use App\DataTransferObjects\StaffProfileData;
use App\Http\Requests\StoreStaffProfileRequest;
use App\Models\StaffProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\View;

#[Middleware('auth')]
class StaffProfileController extends Controller
{
    #[Authorize('viewAny', StaffProfile::class)]
    public function index(): View
    {
        return view('staff-profiles.index');
    }

    #[Authorize('view', 'staffProfile')]
    public function edit(StaffProfile $staffProfile): View
    {
        return view('staff-profiles.edit', [
            'staffProfile' => $staffProfile,
        ]);
    }

    #[Authorize('update', 'staffProfile')]
    public function update(StoreStaffProfileRequest $request, StaffProfile $staffProfile, UpdateStaffProfileAction $action): RedirectResponse
    {
        $data = StaffProfileData::fromRequest($request);
        $addressData = AddressData::fromRequest($request);

        $action($staffProfile, $data, $addressData);

        return redirect()->route('staff-profiles.edit', $staffProfile)->with('status', 'Profile updated.');
    }
}
