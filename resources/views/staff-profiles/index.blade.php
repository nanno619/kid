<x-layouts.app title="Staff Profiles">
    <x-layouts.authenticated title="Staff Profiles">
        <div class="card">
            @if ($staffProfiles->isEmpty())
                <div class="empty">
                    <div class="empty-icon">
                        <i class="ti ti-users icon"></i>
                    </div>
                    <p class="empty-title">No staff profiles yet</p>
                    <p class="empty-subtitle text-secondary">
                        Staff profiles are created automatically once a job application is approved.
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>IC</th>
                                <th>Department</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffProfiles as $staffProfile)
                                <tr>
                                    <td>{{ $staffProfile->full_name }}</td>
                                    <td>{{ $staffProfile->ic_number }}</td>
                                    <td>{{ $staffProfile->department?->name }}</td>
                                    <td>
                                        <a href="{{ route('staff-profiles.edit', $staffProfile) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </x-layouts.authenticated>
</x-layouts.app>
