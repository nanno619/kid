<x-layouts.app title="Edit Staff Profile">
    <x-layouts.authenticated title="Edit Staff Profile">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('staff-profiles.update', $staffProfile) }}">
            @csrf
            @method('PUT')
            <x-staff-profiles.form :staff-profile="$staffProfile" :admin-fields-editable="true" />
        </form>
    </x-layouts.authenticated>
</x-layouts.app>
