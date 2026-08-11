# Design Brief

Visual identity, typography, color, components, and rough per-screen layout for **Taska Seri Impian Bestari**'s admin system. Builds on Tabler UI (Bootstrap 5) as already established in the prototype — this doc fixes conventions so new screens stay consistent without needing a full mockup for each one.

## Brand

- **Name**: Taska Seri Impian Bestari
- **Branding**: text-only for now (navbar brand, page titles). No logo yet — the navbar-brand slot already supports swapping in an image later without restructuring markup.

## Typography

- **Font**: Inter (via Bunny Fonts, already wired through Laravel's Vite font plugin).
- Uses Tabler's default type scale — no custom overrides beyond the font family.

## Color

### Primary
- `--tblr-primary: oklch(50.8% 0.118 165.612)` (≈ `#007a55`, a deep green/teal). Drives buttons, active nav state, links.

### Status colors (Tabler defaults, no overrides)
Used consistently as `badge` components across every module that has a status (children registration, job applications, leave requests) so status is recognizable at a glance regardless of screen:
- **Secondary** (`bg-secondary`) — draft
- **Warning** (`bg-warning`) — submitted / pending review
- **Success** (`bg-success`) — approved
- **Danger** (`bg-danger`) — rejected / returned for revision

### Navbar
- Header uses `data-bs-theme="dark"` (Tabler's dark navbar variant), background `#111827` (Tabler's default `--tblr-gray-900`) — no custom override needed, already in place.

## Layout

- **Fluid layout** (`container-fluid` throughout — navbar, page-header, page-body, footer), established in the dashboard prototype.
- **Horizontal top nav**, no sidebar — primary sections as top-level nav items, sub-pages as dropdowns where a section has multiple children (mirrors the Home/Interface/Forms mechanics already built — real menu content below replaces that placeholder).

### Navigation

The prototype's "Home / Interface / Forms" nav is a placeholder copied from the Tabler demo — real content is this, driven entirely by the permissions seeded in Phase 0 (`spatie/laravel-permission`'s `can()`), not per-role `@if` branching. Each item shows if the logged-in user has **any** of its listed permissions, so principal automatically sees everything admin does without a separate principal-specific menu:

| Nav item | Visible when user can | Teacher sees it? | Admin/Principal sees it? |
|---|---|---|---|
| Dashboard | *(always)* | Yes | Yes |
| Children Registration | `children.create` or `children.approve` | No | Yes |
| Staff Profiles | `staff-profiles.view` | No | Yes |
| My Profile | `staff-profiles.edit-own` | Yes | No (principal edits any profile via Staff Profiles) |
| Job Applications | `job-applications.view` or `job-applications.approve` | No | Yes |
| Leave Applications | `leave-applications.view`, `leave-applications.create`, or `leave-applications.approve` | Yes (own only) | Yes (all staff) |
| Payslips | `payslips.view-own`, `payslips.create`, or `payslips.publish` | Yes (own only) | Yes (all staff) |

Leave Applications and Payslips are the same nav item and route for every role — what differs is what the page shows/allows once you're on it (own records + submit for teacher; all records + create/verify for admin/principal), not a separate menu entry. Children Registration, Staff Profiles, My Profile, and Job Applications are genuinely different screens per role, so they're gated on and off entirely.

**Build incrementally, not all at once**: nav items get wired up as each phase delivers the page it points to — Phase 1 adds Staff Profiles/My Profile, Phase 2 adds Job Applications, Phase 3 adds Children Registration, Phase 4/5 extend the existing Leave Applications/Payslips items. No nav item should ever link to a route that doesn't exist yet.

## Components

Stick to Tabler's stock components rather than building custom ones — keeps the build fast and visually consistent:
- **Lists** — a Livewire component (live search + sortable columns + pagination, per the pattern below), `table` markup with a `badge` status column where the entity has one.
- **Forms** — `card > card-body` wrapping `form-control`/`form-select` fields, grouped into sections matching each paper form's own sections (e.g. Children Registration's Section A–D, see [Form Fields](./FORM_FIELDS.md)).
- **Detail/review screens** — `datagrid` for read-only label/value display (e.g. principal reviewing a submitted registration).
- **Actions** — `btn-list` grouping primary actions (Approve / Reject / Return for Revision); `btn-primary` for the main action, `btn-outline-danger` for destructive ones.
- **Empty states** — Tabler's `empty` component where a list has no records yet.

### Standard list page pattern

Established on Staff Profiles (`resources/views/components/⚡staff-profiles-table.blade.php`), this is the template every future list page (Children Registration, Job Applications, Leave Applications, Payslips) follows:

- The **route/controller stays the entry point and the policy gate** — e.g. `StaffProfileController::index()` keeps its `#[Authorize('viewAny', StaffProfile::class)]` attribute and renders a thin Blade wrapper (`card` + `<livewire:component-name />`).
- The **Livewire component owns its own data and re-checks authorization** in `mount()` (`$this->authorize('viewAny', ...)`) — defense in depth, since a mounted Livewire component has its own AJAX update endpoint independent of the page route that first rendered it.
- **Toolbar** (`card-header`): a "Show [10/15/25/50] entries" per-page `<select>` (`wire:model.live="perPage"`) on the left, search input (`wire:model.live.debounce.300ms`, filtering across the columns shown, e.g. name + IC) on the right.
- **Sort**: clickable column headers (`wire:click.prevent="sortBy('column')"`) toggling asc/desc, with a chevron icon (`ti-chevron-up`/`ti-chevron-down`) marking the active sort column and a neutral `ti-arrows-sort` icon on inactive-but-sortable columns. Only sort by columns that live directly on the table — relation columns (e.g. Department) stay unsorted unless a specific list page needs it.
- **Pagination**: Livewire's `WithPagination` trait with `protected string $paginationTheme = 'bootstrap';` set on the component — this is what makes `{{ $this->results->links() }}` render Livewire's built-in Bootstrap pagination view ("Showing X to Y of Z results" + numbered Previous/1/2/3/Next links with an active-page highlight) instead of the Tailwind default, entirely for free — no custom pagination markup needed.
- **Row actions**: icon-only buttons (e.g. `ti-edit`) with a `title` attribute instead of text buttons ("Edit"), centered in a narrow `w-1 text-center` "Action" column that's always **first** (leftmost), before the data columns — matches the egls reference and keeps actions in a predictable spot regardless of how many data columns a given list has.
- `updated{Property}()` (search, perPage) calls `$this->resetPage()` so changing either always starts back at page 1.
- **Status filter** (once a list page has a status, e.g. Children Registration's draft/submitted/approved): add as another `#[Url]`-synced property alongside search, same pattern.
- Properties (search, sort, perPage, status) use Livewire's `#[Url]` attribute so list state is shareable/bookmarkable, per Livewire's own recommended pattern for filter/search interfaces.

This pattern was cross-checked against another local Tabler+Livewire project's datatable (`egls.test/fi-management`, `app/Livewire/FiManagement/FiList.php`) for a second reference point — same toolbar/pagination/icon-action conventions, minus that project's export buttons and multi-field filter panel, which don't apply here yet.

## Rough Screen Layouts

### Login
Centered card (already built) — no nav chrome, same for principal and teacher.

### Dashboard
Fluid layout, row of summary cards up top (pending leave requests, pending job applications, pending children registrations awaiting review). Exact widgets refined when built, not mocked here.

### Children Registration
- **List**: table — Name / IC / Status / Actions, filterable by status.
- **Create/Edit**: multi-section form matching Sections A–D of the paper form, with a file-upload section for attachments.
- **Review (principal)**: `datagrid` read-only view + Approve / Return for Revision actions.

### Staff / Teacher Profiles
- **List**: table — Name / IC / Role / Actions.
- **Profile**: single-section form (few fields), edit-own-only per the App Flow.

### Job Applications (public + internal)
- **Public form**: same card-based, no-nav-chrome pattern as login, Sections A–B per the paper form.
- **Internal list/review**: same list/review pattern as Children Registration.

### Leave Applications
- **List**: table — Name / Type / Dates / Status.
- **Submit form**: single card — leave type (select), date range, reason (textarea).
- **Review (principal)**: request details alongside the requester's current annual leave balance.

### Payslips
- **List**: table per teacher — Period / Status / Download.
- **Generate (principal)**: pay period picker, single action triggers batch generation for all active staff.

## Open Questions

- Payslip PDF template/layout — deferred until payslip calculation rules are settled (per TDD).
- Logo — pending from the user's sister; text-only brand until then.
