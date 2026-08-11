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
- **Horizontal top nav**, no sidebar — primary sections as top-level nav items, sub-pages as dropdowns where a section has multiple children (mirrors the Home/Interface/Forms pattern already built).

## Components

Stick to Tabler's stock components rather than building custom ones — keeps the build fast and visually consistent:
- **Lists** — `table` (staff, children, leave/job application queues) with a `badge` status column.
- **Forms** — `card > card-body` wrapping `form-control`/`form-select` fields, grouped into sections matching each paper form's own sections (e.g. Children Registration's Section A–D, see [Form Fields](./FORM_FIELDS.md)).
- **Detail/review screens** — `datagrid` for read-only label/value display (e.g. principal reviewing a submitted registration).
- **Actions** — `btn-list` grouping primary actions (Approve / Reject / Return for Revision); `btn-primary` for the main action, `btn-outline-danger` for destructive ones.
- **Empty states** — Tabler's `empty` component where a list has no records yet.

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
