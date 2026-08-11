<x-layouts.app title="My Profile">
    <x-layouts.authenticated title="My Profile">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            <x-staff-profiles.form :staff-profile="$staffProfile" :admin-fields-editable="false" />
        </form>
    </x-layouts.authenticated>
</x-layouts.app>
