<?php

use App\Models\StaffProfile;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    #[Url]
    public string $search = '';

    #[Url]
    public string $sortColumn = 'full_name';

    #[Url]
    public string $sortDirection = 'asc';

    #[Url]
    public int $perPage = 15;

    public function mount(): void
    {
        $this->authorize('viewAny', StaffProfile::class);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $column): void
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    #[Computed]
    public function staffProfiles()
    {
        return StaffProfile::query()
            ->with('department')
            ->when($this->search, fn ($query) => $query
                ->where('full_name', 'like', "%{$this->search}%")
                ->orWhere('ic_number', 'like', "%{$this->search}%"))
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);
    }
};
?>

<div>
    <div class="card-header">
        <div class="row align-items-center g-2 w-100">
            <div class="col-auto text-muted">
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0">Show</label>
                    <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto;">
                        @foreach ([10, 15, 25, 50] as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                    <label class="mb-0">entries</label>
                </div>
            </div>
            <div class="col text-muted">
                <div class="input-icon ms-auto" style="max-width: 300px;">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search by name or IC…">
                    <span class="input-icon-addon">
                        <i class="ti ti-search icon"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if ($this->staffProfiles->isEmpty())
        <div class="empty">
            <div class="empty-icon">
                <i class="ti ti-users icon"></i>
            </div>
            <p class="empty-title">No staff profiles found</p>
            <p class="empty-subtitle text-secondary">
                @if ($search)
                    No results match "{{ $search }}".
                @else
                    Staff profiles are created automatically once a job application is approved.
                @endif
            </p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th class="w-1 text-center">Action</th>
                        <th>
                            <a href="#" wire:click.prevent="sortBy('full_name')" class="text-reset d-flex align-items-center gap-1">
                                Name
                                @if ($sortColumn === 'full_name')
                                    <i class="ti ti-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} icon icon-sm"></i>
                                @else
                                    <i class="ti ti-arrows-sort icon icon-sm text-muted"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="#" wire:click.prevent="sortBy('ic_number')" class="text-reset d-flex align-items-center gap-1">
                                IC
                                @if ($sortColumn === 'ic_number')
                                    <i class="ti ti-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }} icon icon-sm"></i>
                                @else
                                    <i class="ti ti-arrows-sort icon icon-sm text-muted"></i>
                                @endif
                            </a>
                        </th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->staffProfiles as $staffProfile)
                        <tr wire:key="staff-profile-{{ $staffProfile->id }}">
                            <td class="text-center">
                                <a href="{{ route('staff-profiles.edit', $staffProfile) }}" class="text-primary px-1" title="Edit">
                                    <i class="ti ti-edit icon"></i>
                                </a>
                            </td>
                            <td>{{ $staffProfile->full_name }}</td>
                            <td>{{ $staffProfile->ic_number }}</td>
                            <td>{{ $staffProfile->department?->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $this->staffProfiles->links() }}
        </div>
    @endif
</div>
