# App Flow

Screen-by-screen user journeys for Kidner, building on the [PRD](./PRD.md) and [TDD](./TDD.md). Covers what each role sees and what happens on each action.

## Roles & Entry Points

- **Public / Job Applicant** — no login. Only touches the public Job Application form.
- **Teacher** — logs in. Narrow scope: manages own profile only, submits own leave requests, views own published payslips. No access to children registration, other staff profiles, job applications, or payroll.
- **Admin** — logs in. Day-to-day data entry across most modules, all subject to principal review: children registration (full create/edit/submit — teachers have no access to this at all), staff/teacher profile management, job application screening, leave application visibility, and payslip/salary keying.
- **Principal** — logs in. Full oversight and all final approval authority: approves/returns children registration, approves/rejects job applications, approves/rejects leave applications, verifies/publishes/returns payslips. Can also edit any staff profile directly.
- **Parent** — Phase 2, not in v1.

## Authentication

1. User visits login page → enters email/password.
2. On success, redirected to a role-aware dashboard (same shell, each role sees only the sections/actions listed above).
3. On failure, inline validation error, stays on login page.
4. Logout available from the user menu on any screen → back to login page.

## Public Job Application Flow (unauthenticated)

1. Applicant visits the public Job Application page (no login required).
2. Fills out the form (fields per the paper job application form — see [Form Fields](./FORM_FIELDS.md)) and submits.
3. Submission is stored with status `pending`. Principal is notified (email + in-app) that a new application arrived.
4. Applicant sees a confirmation screen ("Your application has been received").
5. Admin screens the application (see Admin Flows below); principal makes the final approve/reject call (see Principal Flows below).
6. **On approval**: a teacher account is auto-created for the applicant, and the applicant is emailed their login credentials (or a set-password link) plus a notice that they've been approved.
7. **On rejection**: applicant is emailed a rejection notice. No account is created.

## Principal Flows

### Dashboard
- Landing screen after login. Overview of pending items needing attention: submitted children registrations, pending leave requests, pending job applications, submitted payslips, recent activity. (Exact widgets TBD in Design Brief.)

### Children Registration
1. List screen: search/filter registered children, filterable by status (`draft` / `submitted` / `approved`).
2. Open a `submitted` registration → review details/attachments admin transcribed against the paper form.
3. Approve → status becomes `approved`. Locked from further edits/deletion by admin.
4. Return for revision → status goes back to `draft`, assigned back to the admin who created it, who can correct and resubmit.
5. Principal can also create/edit/delete records directly, same as admin can (see Admin Flows) — soft-delete throughout, records are recoverable, not permanently destroyed.

### Staff / Teacher Profiles
1. List screen: view all staff, search/filter.
2. View a staff member's profile in detail.
3. Edit any staff profile directly.
4. Profiles are created automatically when a job application is approved (see above) — no separate manual "add teacher" flow needed for v1.

### Job Applications
1. List screen: pending / approved / rejected applications, filterable by status.
2. Open an application → view submitted details/attachments (and admin's screening notes, if any).
3. Approve → triggers auto account creation + applicant notified (see Public flow above).
4. Reject → applicant notified, no account created.

### Leave Applications
1. List screen: pending / approved / rejected leave requests across all staff.
2. Open a request → view requested dates, reason, and the requesting teacher's current leave balance.
3. Approve → teacher's leave balance is decremented by the requested days; teacher is notified (email + in-app).
4. Reject → teacher is notified (email + in-app); balance unaffected.

### Payslips
1. List screen: payslips filterable by status (`draft` / `submitted` / `published`).
2. Open a `submitted` payslip → review the salary breakdown (basic salary, overtime, allowances, EPF/SOCSO/EIS, advance) admin keyed in.
3. Publish (individually or in batch) → status becomes `published`, locked from further edits, PDF generated (via mPDF), and the teacher is notified (email + in-app) that their payslip is ready.
4. Return for revision → status goes back to `draft`, assigned back to the admin who created it, who can correct and resubmit.
5. Principal can view/download any staff member's payslip history, at any status.

## Admin Flows

### Dashboard
- Landing screen after login. Overview of admin's own pending work across modules: draft/returned children registrations, draft/returned payslips, new job applications to screen. (Exact widgets TBD in Design Brief.)

### Children Registration
1. List screen: search/filter all registered children, filterable by status (`draft` / `submitted` / `approved`).
2. Create a registration → saved as `draft`. Transcribes a paper registration form into the system (Sections A–D, see [Form Fields](./FORM_FIELDS.md)). Freely editable and deletable while in `draft`.
3. Submit a `draft` → status becomes `submitted`, locked from further edits/deletion by admin, queued for principal review.
4. If the principal returns it for revision, status goes back to `draft` → admin can edit and resubmit.
5. Once `approved` by the principal, admin can no longer edit or delete the record.

### Staff / Teacher Profiles
1. List screen: view all staff, search/filter.
2. View/edit a staff member's profile — e.g. fill in EPF number, staff number, department, bank details once a job application is approved and the profile auto-created.

### Job Applications
1. List screen: pending / approved / rejected applications, filterable by status.
2. Open an application → view submitted details/attachments, screen the applicant.
3. Admin does not have final approve/reject authority — that decision is queued for the principal (see Principal Flows).

### Leave Applications
1. List screen: view all leave requests and balances across staff (read access — no approve/reject action available to admin).

### Payslips
1. List screen: own draft/submitted/returned payslips, filterable by status and pay month.
2. Create a payslip for a staff member → saved as `draft`. Key in basic salary, overtime, allowances, EPF/SOCSO/EIS (staff + employer), advance, pay period dates. Freely editable while in `draft`.
3. Submit a `draft` → status becomes `submitted`, locked from further admin edits, queued for principal verification.
4. If the principal returns it for revision, status goes back to `draft` → admin can correct and resubmit.
5. Once `published` by the principal, admin can no longer edit it.

## Teacher Flows

### Dashboard
- Landing screen after login. Shows own leave balance, recent notifications (e.g. "your leave was approved," "new payslip available").

### My Profile
1. View own profile.
2. Edit own profile only — teachers cannot view or edit another staff member's profile, and have no access to any other module.

### Leave Applications
1. View own leave balance and request history. Annual leave (Cuti Tahunan) balance starts at 8 days per teacher and carries forward to the following year (does not reset to 0). Only Cuti Tahunan draws down this balance — other leave types (Kecemasan, Tanpa Gaji, Ganti, Sakit, Lain-lain) are tracked but don't affect it.
2. Submit a new leave request (leave type, dates, reason — see [Form Fields](./FORM_FIELDS.md) for the full field list).
3. Request appears as `pending` until principal reviews it.
4. Notified (email + in-app) when approved/rejected.

### Payslips
1. View own payslip history — `published` payslips only, `draft`/`submitted` ones aren't visible to the teacher.
2. Notified (email + in-app) when a payslip is published.
3. Download own payslip PDF.

## Open Questions

- Payslip pay period cadence (assumed monthly) — confirm.
- Exact editable fields on children registration/job application forms once transcribed into UI form design (field list is settled, see [Form Fields](./FORM_FIELDS.md); form layout/UX comes in the Design Brief).
