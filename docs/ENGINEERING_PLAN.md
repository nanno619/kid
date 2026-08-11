# Engineering Plan

Build order for Kidner, broken into small, testable tasks with dependencies and acceptance criteria. Builds on the [PRD](./PRD.md), [TDD](./TDD.md), [App Flow](./APP_FLOW.md), [Design Brief](./DESIGN_BRIEF.md), and [Backend Schema](./BACKEND_SCHEMA.md) — this doc doesn't repeat decisions already made there, only sequences the work.

Each task should be built test-first (Pest feature tests per the project's TDD workflow), formatted with Pint, and kept small enough to land as its own PR/commit.

## Already Done (prototype)

- Login page + Dashboard shell (Blade + Tabler, fluid layout, dark navbar).
- `routes/web.php`: `/login` (GET/POST), `/dashboard` (GET) — placeholder controllers, no real auth yet.
- Primary color, app name (`Taska Seri Impian Bestari`) configured.

These get replaced/extended in Phase 0, not rebuilt from scratch.

## Phase 0 — Foundation

Nothing else can be built until this lands; every later phase depends on it.

1. **Install dependencies** — `laravel/fortify`, `spatie/laravel-permission`, `spatie/laravel-medialibrary`, `spatie/laravel-activitylog`, `mpdf/mpdf` (per TDD). *Acceptance: `composer show` lists all five; app boots without error.*
2. **`ulid` convention** — apply Laravel's built-in `Illuminate\Database\Eloquent\Concerns\HasUlids` trait to every model except `Ref*` models, overriding `uniqueIds()` to return `['ulid']` (so `id` stays the primary key) and `getRouteKeyName()` to return `'ulid'`. *Acceptance: creating any non-ref model auto-populates a unique `ulid`; route model binding resolves by `ulid`, not `id`.*
3. **Roles & permissions** — migrate Spatie's tables, seed the three roles (`principal`, `admin`, `teacher`) with their permissions per TDD's breakdown. *Acceptance: a Pest test asserts each role has exactly the permissions listed in the TDD.*
4. **`users` table migration** — add `ulid`, `short_name`, plus Fortify's own columns (`two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `email_verified_at`). *Acceptance: migration runs clean; Fortify's default feature tests pass.*
5. **Fortify wiring** — configure Fortify to use the existing custom Blade login view instead of stubbed views; enable email verification + 2FA. Replace the placeholder `AuthController` from the prototype. *Acceptance: login/logout works end-to-end via Fortify; existing login page visually unchanged.*
6. **`ref_*` tables + seeders** — migrate all eleven reference tables (`ref_countries`, `ref_genders`, `ref_religions`, `ref_races`, `ref_marital_statuses`, `ref_departments`, `ref_states`, `ref_leave_types`, `ref_illnesses`, `ref_health_issues`, `ref_banks`) and seed each with its known values (`ref_leave_types` needs the `slug` column populated, especially `cuti-tahunan`). *Acceptance: seeders are idempotent (safe to re-run); `ref_leave_types` has a row with `slug = 'cuti-tahunan'`.*
7. **`addresses` table (polymorphic)** — migrate, add the `HasAddress`-style relation to any model that needs one. *Acceptance: a Pest test creates an address against a dummy model via the morph relation.*
8. **In-app notifications table** — `php artisan notifications:table` + migrate. *Acceptance: a test notification can be sent and appears via `$user->notifications`.*
9. **Activity log** — migrate `spatie/laravel-activitylog`'s table, apply the `LogsActivity` trait to `children`, `job_applications`, `leave_applications`, `payslips`, and `staff_profiles`. *Acceptance: a Pest test triggers an update on each of those models and asserts an `Activity` record is written with the correct causer.*

## Phase 1 — Staff Foundation

Depends on Phase 0 (roles, ulid, addresses).

1. **`staff_profiles` migration + model** — 1:1 with `users`, `HasAddress`. *Acceptance: factory + model relationship test (`$user->staffProfile`).*
2. **Seed a principal + admin account** for local dev (`php artisan db:seed`), each with a `staff_profiles` row. *Acceptance: can log in locally as either seeded account immediately after `migrate:fresh --seed`.*
3. **Staff profile policy** — principal/admin can view & edit any profile; teacher can view & edit only their own. *Acceptance: Pest policy tests cover all three roles × both actions.*
4. **Staff profile UI** — list (principal/admin), detail/edit (principal/admin: any; teacher: own only), per the Design Brief's list/datagrid pattern. *Acceptance: feature tests per role match the App Flow's Staff/Teacher Profiles sections.*

## Phase 2 — Job Applications & Onboarding

Depends on Phase 1 (`staff_profiles`, since approval creates one).

1. **`job_applications` migration + model**, with `ic_copy`/`academic_certificate` media collections. *Acceptance: factory covers every field from Form Fields.*
2. **Public application form** (unauthenticated route) + confirmation screen. *Acceptance: feature test submits the form as a guest, asserts a `pending` record + principal notification.*
3. **Admin: job applications list/detail (screening)** — view-only, no approve/reject action. *Acceptance: policy test confirms admin cannot approve/reject.*
4. **Principal: approve/reject** — approve auto-creates a `users` + `staff_profiles` record (copying every overlapping field per Backend Schema), emails credentials; reject emails a rejection notice. *Acceptance: feature test asserts the created account has correct role (`teacher`) and copied fields; a second test asserts rejection sends no account.*

## Phase 3 — Children Registration

Depends on Phase 0 only (no dependency on Phase 1/2 data, though `created_by`/`reviewed_by` point at `users`).

1. **`children`, `child_guardians`, `child_illnesses`, `child_health_issues` migrations + models**, with the 7 media collections. *Acceptance: factories cover every field; soft deletes work.*
2. **Admin: create/edit/delete a `draft`** — full Section A–D form matching Form Fields, attachments. *Acceptance: feature test walks through create → edit → delete while in `draft`.*
3. **Admin: submit** — `draft` → `submitted`, locks admin edits. *Acceptance: test asserts admin can no longer edit/delete after submit.*
4. **Principal: review → approve or return** — approve locks the record; return sets `return_reason` and reverts to `draft` assigned back to the same admin. *Acceptance: two feature tests, one per branch.*
5. **Parent confirmation checkbox** — `parent_confirmed_at` set via an in-app checkbox during create/edit. *Acceptance: test asserts the timestamp is null until checked.*

## Phase 4 — Leave Management

Depends on Phase 1 (`staff_profiles`/roles) — leave applications are per-teacher.

1. **`leave_applications`, `leave_balances` migrations + models.** *Acceptance: factory; `leave_balances` defaults to 8 days on staff creation (hook into staff_profiles creation, whether via job application approval or seeding).*
2. **Teacher: submit a leave request** + view own balance/history. *Acceptance: feature test submits a request, asserts `pending` status and balance unchanged.*
3. **Admin: view-only list** across all staff. *Acceptance: policy test confirms no approve/reject action available to admin.*
4. **Principal: approve/reject** — approving a `cuti-tahunan` request (matched via `ref_leave_types.slug`) decrements `leave_balances.balance_days`; other leave types don't touch the balance. Both branches notify the teacher. *Acceptance: two feature tests — one per leave type category, asserting balance behavior.*

## Phase 5 — Payroll

Depends on Phase 1 (`staff_profiles`) and Phase 0's mPDF dependency.

1. **`payslips` migration + model**, `pdf` media collection. *Acceptance: factory covers every salary column.*
2. **Admin: create/edit/delete a `draft` payslip** per staff member. *Acceptance: feature test create → edit → delete while `draft`.*
3. **Admin: submit** — `draft` → `submitted`. *Acceptance: locks admin edits, matches Phase 3's submit pattern.*
4. **Principal: review → publish or return** — publish generates the PDF via mPDF, notifies the teacher, locks the record; return sets `return_reason`, reverts to `draft`. *Acceptance: two feature tests, one per branch; published test asserts a PDF media item exists.*
5. **Teacher: view/download own published payslips only.** *Acceptance: policy test confirms `draft`/`submitted` payslips are invisible to the teacher, even their own.*

## Phase 6 — Polish

Depends on all prior phases being functionally complete.

1. **Role-aware dashboards** — principal/admin/teacher widgets per App Flow (exact widgets from Design Brief). *Acceptance: each role's dashboard shows only what App Flow specifies for that role.*
2. **In-app notification center UI** — bell/dropdown listing unread notifications (leave, job application, payslip, children registration events per TDD's notification list). *Acceptance: feature test per notification event type confirms it appears in the recipient's notification list.*
3. **Browser tests for the golden paths** — `pestphp/pest-plugin-browser` tests (`tests/Browser/`) covering login (incl. 2FA), the full children registration draft→submit→approve cycle, and the payslip draft→submit→publish cycle, since these involve real JS interactions (dropdowns, file uploads, form flows) that HTTP feature tests don't exercise. *Acceptance: each covered journey passes with `assertNoJavaScriptErrors()`.*
4. **Full regression pass** — `php artisan test --compact`, `vendor/bin/pint --format agent`, manual click-through of every App Flow journey in-browser. *Acceptance: green test suite (including browser tests), clean Pint, no console/browser errors on a full walkthrough.*

## Notes

- Phases 2, 3, and 4 have no hard dependency on each other (all only depend on Phase 0/1) — they can be built in any order, or in parallel, once Phase 1 lands. Phase 5 depends on Phase 1 only, same story.
- Deployment target is still an open question (per TDD) — not blocking for local development, but needs resolving before this plan includes a "ship it" phase.
- **Navigation is built incrementally, not as its own phase** — see the Design Brief's Navigation section for the full permission-gated nav table. Each phase that lands a new page (Staff Profiles in Phase 1, Job Applications in Phase 2, Children Registration in Phase 3, etc.) adds that page's nav item as part of the same task, replacing the prototype's placeholder "Home / Interface / Forms" menu piece by piece. No nav item should ship pointing at a route that doesn't exist yet.
