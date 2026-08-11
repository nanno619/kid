# Technical Design Document (TDD)

## Overview

Technical decisions for building Kidner, the kindergarten admin system described in the [PRD](./PRD.md). This is the source of truth for tech stack, architecture, and third-party tools — the Backend Schema and Engineering Plan build on top of what's decided here.

## Stack

- **Framework**: Laravel 13.24 (PHP 8.4)
- **Frontend**: Blade + Tabler UI (Bootstrap 5), Vite for asset bundling
- **Database**: MySQL
- **Testing**: Pest, plus `pestphp/pest-plugin-browser` for real-browser tests (`tests/Browser/`) — Playwright-backed, covers what Dusk would without a second overlapping framework
- **Local environment**: Laravel Herd

## Authentication & Authorization

- **Auth**: [Laravel Fortify](https://laravel.com/docs/fortify) — headless, so it only supplies the backend routes/logic (login, email verification, two-factor authentication); the existing custom Blade/Tabler login view stays as-is rather than being replaced by Breeze/Jetstream-style stubbed views.
  - Email verification enabled.
  - Two-factor authentication (TOTP) enabled.
- **Roles/Permissions**: [`spatie/laravel-permission`](https://spatie.be/docs/laravel-permission) for role-based access control.
  - V1 roles: `principal`, `admin`, `teacher`.
  - **Principal** — full oversight and all final approval authority: approve/return children registration, approve/reject job applications, approve/reject leave applications, verify/publish/return payslips. Can also edit any staff profile.
  - **Admin** — day-to-day data entry, all subject to principal review:
    - Children Registration: create/edit/submit (teachers have no access to this module at all).
    - Staff/Teacher Profiles: view/manage (e.g. fill in EPF/staff number/bank details after a job application is approved).
    - Job Applications: view/screen incoming applications (final approve/reject stays principal-only).
    - Leave Applications: view requests/balances across staff (final approve/reject stays principal-only).
    - Payslips: key in salary data, submit for principal verification.
  - **Teacher** — narrow scope: view/edit own profile only, submit own leave applications, view own published payslips. No access to children registration, other staff profiles, job applications, or payroll.
- Parent role/login is out of scope for v1 (Phase 2, per PRD).

## File Storage & Media

- **Storage**: Local filesystem for now (Laravel's `local` disk). Not cloud storage in v1 — revisit if the app needs to scale beyond a single server.
- **Media handling**: [`spatie/laravel-medialibrary`](https://spatie.be/docs/laravel-medialibrary) for attachments — job application resumes/documents, children registration attachments (e.g. birth certificate), staff profile photos.

## PDF Generation (Payslips)

- **Library**: mPDF for generating payslip PDFs.
- Payslip template/layout is defined separately in the Design Brief; this doc only fixes the generation approach.
- Payslip calculation structure (basic salary, overtime, allowances, EPF/SOCSO/EIS, advance) is settled — see Backend Schema.

## Auditing

- [`spatie/laravel-activitylog`](https://spatie.be/docs/laravel-activitylog) for a full audit trail — who did what and when. Applied via the `LogsActivity` trait across the domain models with review/approval workflows (`children`, `job_applications`, `leave_applications`, `payslips`) and anywhere else it's useful (e.g. `staff_profiles` edits). Logs the causer (acting user) and before/after attribute changes automatically.

## Notifications

- **Channels**: Email + in-app (database) notifications, using Laravel's built-in notification system (`Illuminate\Notifications`, `mail` + `database` channels).
- V1 notification events (initial list, to refine in Engineering Plan):
  - Leave application submitted → notify principal
  - Leave application approved/rejected → notify teacher
  - Job application submitted → notify principal
  - Job application approved/rejected → notify applicant (email only, since applicants aren't system users)

## Deployment

- Undecided for now. Laravel Cloud is the path of least resistance if/when this needs to go live (per project conventions), but not committed yet.

## New Dependencies to Add

None of these are installed yet — to be added via `composer require` when implementation starts, with approval at that time (per project convention of not changing dependencies without approval):
- `laravel/fortify`
- `spatie/laravel-permission`
- `spatie/laravel-medialibrary`
- `spatie/laravel-activitylog`
- `mpdf/mpdf`
- `pestphp/pest-plugin-browser` (dev dependency)

## Open Questions

- Deployment target.
