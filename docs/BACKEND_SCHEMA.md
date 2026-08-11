# Backend Schema

Data model for Kidner, derived from the [Form Fields](./FORM_FIELDS.md), [App Flow](./APP_FLOW.md), and [TDD](./TDD.md). Table/column names are a starting point for migrations, not final — types and constraints get refined during implementation.

## Conventions

- All tables get standard `id`, `created_at`, `updated_at`. Soft-deletable tables (per App Flow) also get `deleted_at`.
- **Every table except `ref_*` tables** also gets a `ulid` column (string(26), unique, indexed). `id` (auto-increment) stays the primary key and is what FKs reference internally; `ulid` is used only for route model binding. Implemented via Laravel's built-in `Illuminate\Database\Eloquent\Concerns\HasUlids` trait on each model, with `uniqueIds()` overridden to return `['ulid']` (instead of the default, which would make ulid the primary key) and `getRouteKeyName()` returning `'ulid'`.
- Roles (`principal`, `admin`, `teacher`) and permissions are handled entirely by `spatie/laravel-permission`'s own tables (`roles`, `permissions`, `model_has_roles`, etc.) — not modeled here.
- File attachments are handled entirely by `spatie/laravel-medialibrary`'s own `media` table — models get a `HasMedia` trait and named media collections (listed per entity below), not custom file columns.
- In-app notifications use Laravel's built-in `notifications` table (polymorphic, via `php artisan notifications:table`) — not modeled here.
- Audit trail uses `spatie/laravel-activitylog`'s own `activity_log` table (polymorphic, records the causer + before/after attribute changes) — not modeled here. Models get the `LogsActivity` trait.
- Any field that repeats the same category of value across multiple forms (gender, religion, race, nationality, marital status, department, leave type, illnesses, health issues) is normalized into a `ref_*` lookup table and referenced by FK, rather than hardcoded as an enum/JSON — see [Reference / Lookup Tables](#reference--lookup-tables-ref_). This lets the principal manage these lists later without a code deploy.
- Age fields (child's age, staff's age) are **computed from `date_of_birth`**, not stored — avoids the value going stale.

## Reference / Lookup Tables (`ref_*`)

| Table | Columns | Used by |
|---|---|---|
| `ref_countries` | id, name | nationality (children, guardians) |
| `ref_genders` | id, name | children.gender, job_applications.gender |
| `ref_religions` | id, name | children, guardians, job_applications |
| `ref_races` | id, name | children, guardians, job_applications |
| `ref_marital_statuses` | id, name | guardians (Taraf Perkahwinan), job_applications (Status) |
| `ref_departments` | id, name | staff_profiles (Bahagian) — open-ended, e.g. Playschool/Babyschool plus any added later |
| `ref_states` | id, name, country_id FK → ref_countries | used by the `addresses` table's `state_id` |
| `ref_leave_types` | id, name, slug | leave_applications.leave_type — e.g. Cuti Tahunan (`slug: cuti-tahunan`), Cuti Kecemasan, Cuti Tanpa Gaji, Cuti Ganti, Cuti Sakit, Cuti Lain-lain. `slug` is how `leave_balances` reliably identifies Cuti Tahunan, instead of matching on the display name. |
| `ref_illnesses` | id, name | children (Section C — Lelah, Batuk Kering, Sakit Jantung, Gastrik, Barah, Sawan, Lain-lain) |
| `ref_health_issues` | id, name | children (Section C — Cepat Penat, Sakit Dada, Pening Kepala, Kurang Penglihatan, Kurang Pendengaran, Alahan, Lain-lain) |
| `ref_banks` | id, name | staff_profiles (Bank Name, for payslip bank transfer details) |

## Entities

### `addresses`
Polymorphic — one address per `staff_profiles` / `children` / `job_applications` record (the morph relation leaves room for more than one per entity later, though v1 only ever creates one). Replaces what would otherwise be a single free-text address column duplicated across three tables.
| Column | Type | Notes |
|---|---|---|
| ulid | string(26), unique | route model binding |
| addressable_type | string | polymorphic |
| addressable_id | FK | polymorphic |
| address_line_1 | string | |
| address_line_2 | string, nullable | |
| address_line_3 | string, nullable | |
| state_id | FK → ref_states, nullable | |
| district | string, nullable | plain text — not a `ref_*` table unless you want it to be |
| city | string, nullable | plain text — not a `ref_*` table unless you want it to be |
| postcode | string, nullable | |

### `users`
Auth only — profile data lives in `staff_profiles`. Two-factor columns are Fortify's own (added by its migration, not custom).
| Column | Type | Notes |
|---|---|---|
| ulid | string(26), unique | route model binding |
| name | string | |
| short_name | string, nullable | display name (e.g. navbar/greeting), shorter than `name` |
| email | string, unique | |
| email_verified_at | timestamp, nullable | Fortify |
| password | string | |
| two_factor_secret | text, nullable | Fortify — encrypted |
| two_factor_recovery_codes | text, nullable | Fortify — encrypted |
| two_factor_confirmed_at | timestamp, nullable | Fortify |

Roles assigned via spatie/laravel-permission (`principal` / `admin` / `teacher`).

### `staff_profiles`
One-to-one with `users`. Covers both the Teacher Profile form and principal's own profile.
| Column | Type | Notes |
|---|---|---|
| ulid | string(26), unique | route model binding |
| user_id | FK → users | unique |
| staff_number | string, unique | "No. Staff" |
| full_name | string | capital letters, per form |
| ic_number | string | No. Kad Pengenalan |
| date_of_birth | date | age computed from this |
| gender_id | FK → ref_genders | copied from job_applications on approval |
| race_id | FK → ref_races | copied from job_applications on approval |
| religion_id | FK → ref_religions | copied from job_applications on approval |
| marital_status_id | FK → ref_marital_statuses, nullable | copied from job_applications on approval; can change after hire |
| mobile_number | string | |
| siblings_count | integer, nullable | copied from job_applications on approval |
| education_level | string, nullable | copied from job_applications on approval |
| ambition | string, nullable | copied from job_applications on approval |
| field_experience | text, nullable | copied from job_applications on approval |
| previous_work_experience | text, nullable | copied from job_applications on approval |
| reason_left_previous_job | text, nullable | copied from job_applications on approval |
| has_mental_illness | boolean, nullable | copied from job_applications on approval |
| illness_details | text, nullable | copied from job_applications on approval |
| family_member_name | string, nullable | copied from job_applications on approval; can change after hire |
| family_member_ic | string, nullable | copied from job_applications on approval |
| family_member_occupation | string, nullable | copied from job_applications on approval |
| family_member_employer_address | text, nullable | copied from job_applications on approval |
| family_member_phone | string, nullable | copied from job_applications on approval |
| epf_number | string, nullable | No. KWSP |
| department_id | FK → ref_departments, nullable | Bahagian |
| bank_id | FK → ref_banks, nullable | Bank Name |
| bank_account_number | string, nullable | Account No. |

Has one `addresses` record (polymorphic). Created automatically when a `job_application` is approved (per App Flow), copying every matching field from the application (see "copied from job_applications on approval" notes above) plus the address. `staff_profiles` is then independently editable going forward — `job_applications` stays an untouched historical snapshot of what was submitted.

`ic_number`/`epf_number`/`staff_number`/`department_id`/`bank_id`/`bank_account_number` still need to be filled in afterward by the principal — none of these are on the job application form (the applicant's IC number specifically is never collected on the paper form, only the family member's is).

### `children`
Soft-deletable. Section A fields + workflow state.
| Column | Type | Notes |
|---|---|---|
| ulid | string(26), unique | route model binding |
| full_name | string | capital letters |
| ic_number | string, nullable | child may not have IC yet |
| birth_certificate_number | string | |
| date_of_birth | date | age computed from this |
| gender_id | FK → ref_genders | Jantina |
| religion_id | FK → ref_religions | |
| race_id | FK → ref_races | |
| nationality_id | FK → ref_countries | |
| has_disability | boolean | |
| disability_details | text, nullable | |
| status | enum('draft','submitted','approved') | |
| return_reason | text, nullable | set when principal returns a submission for revision (status reverts to `draft`) |
| created_by | FK → users | admin (or principal) who registered the child — teachers have no access to this module |
| reviewed_by | FK → users, nullable | principal who approved/returned it — also stands in for the "principal's signature" on Section D |
| reviewed_at | timestamp, nullable | |
| parent_confirmed_at | timestamp, nullable | in-app declaration checkbox (Section D "parent's signature") — presence of a timestamp means confirmed |

Has one `addresses` record (polymorphic — Mailing Address). **Media collections**: `birth_certificate`, `father_ic`, `mother_ic`, `health_booklet`, `parents_payslip`, `covid_vaccine_parents`, `covid_vaccine_child`.

### `child_illnesses`
Pivot — a child can have multiple illnesses checked (Section C).
| Column | Type | Notes |
|---|---|---|
| ulid | string(26), unique | route model binding |
| child_id | FK → children | |
| ref_illness_id | FK → ref_illnesses | |
| detail | string, nullable | free text when the illness is "Lain-lain" |

### `child_health_issues`
Pivot — a child can have multiple health issues checked (Section C).
| Column | Type | Notes |
|---|---|---|
| ulid | string(26), unique | route model binding |
| child_id | FK → children | |
| ref_health_issue_id | FK → ref_health_issues | |
| detail | string, nullable | free text for "Alahan" (allergy detail) or "Lain-lain" |

### `child_guardians`
Section B — one row per parent/guardian, `type` distinguishes father vs. mother (avoids duplicating the same 11 columns twice).
| Column | Type | Notes |
|---|---|---|
| ulid | string(26), unique | route model binding |
| child_id | FK → children | |
| type | enum('father','mother') | unique per (child_id, type) |
| full_name | string | |
| ic_number | string | |
| date_of_birth | date | |
| race_id | FK → ref_races | |
| religion_id | FK → ref_religions | |
| nationality_id | FK → ref_countries | |
| marital_status_id | FK → ref_marital_statuses | Taraf Perkahwinan |
| home_phone | string, nullable | |
| mobile_number | string | |
| office_number | string, nullable | |
| email | string, nullable | |
| employer_position_address | text | Nama Jawatan dan Alamat Majikan |

### `job_applications`
Public submission — no `user_id` until approved.
| Column | Type | Notes |
|---|---|---|
| ulid | string(26), unique | route model binding |
| applicant_name | string | |
| gender_id | FK → ref_genders | |
| date_of_birth | date | age computed from this |
| race_id | FK → ref_races | |
| religion_id | FK → ref_religions | |
| siblings_count | integer | |
| mobile_number | string | |
| education_level | string | |
| ambition | string | |
| marital_status_id | FK → ref_marital_statuses | Status |
| field_experience | text | Pengalaman dalam bidang yang dipohon |
| previous_work_experience | text | |
| reason_left_previous_job | text, nullable | |
| has_mental_illness | boolean | |
| illness_details | text, nullable | |
| family_member_name | string | Nama Suami/Bapa (Section B) |
| family_member_ic | string | |
| family_member_occupation | string | |
| family_member_employer_address | text | |
| family_member_phone | string | |
| status | enum('pending','approved','rejected') | |
| reviewed_by | FK → users, nullable | principal |
| reviewed_at | timestamp, nullable | |
| created_user_id | FK → users, nullable | set on approval, links to the auto-created teacher account |

Has one `addresses` record (polymorphic — Home Address). **Media collections**: `ic_copy` (Salinan No. Kad Pengenalan), `academic_certificate` (Salinan Sijil Akademik).

### `leave_applications`
| Column | Type | Notes |
|---|---|---|
| ulid | string(26), unique | route model binding |
| staff_id | FK → users | |
| ref_leave_type_id | FK → ref_leave_types | |
| other_type_detail | string, nullable | free text when the leave type is "Cuti Lain-lain" |
| date_from | date | |
| date_to | date | |
| duration_days | integer | |
| reason | text | |
| status | enum('pending','approved','rejected') | |
| reviewed_by | FK → users, nullable | principal |
| reviewed_at | timestamp, nullable | |

`Jawatan` (role) and `Bahagian` (department) come from the requester's `staff_profiles` relation rather than being duplicated here.

### `leave_balances`
One-to-one with `users` (teacher). Only the leave type with `ref_leave_types.slug = 'cuti-tahunan'` affects this.
| Column | Type | Notes |
|---|---|---|
| ulid | string(26), unique | route model binding |
| staff_id | FK → users, unique | |
| balance_days | integer, default 8 | carries forward year to year, never resets to 0 |

### `payslips`
| Column | Type | Notes |
|---|---|---|
| ulid | string(26), unique | route model binding |
| staff_id | FK → users | |
| salary_month | string (e.g. `2026-08`) | which month this salary is for |
| salary_date | date | disbursement date |
| start_date | date | pay period start |
| end_date | date | pay period end |
| basic_salary | decimal | |
| overtime | decimal, nullable | |
| allowances | decimal, nullable | |
| advance | decimal, nullable | salary advance deduction |
| epf_staff | decimal | employee EPF contribution |
| epf_employer | decimal | employer EPF contribution |
| socso_staff | decimal | employee SOCSO contribution |
| socso_employer | decimal | employer SOCSO contribution |
| eis_staff | decimal | employee EIS contribution |
| eis_employer | decimal | employer EIS contribution |
| status | enum('draft','submitted','published') | `draft` = admin still keying/editing; `submitted` = awaiting principal verification; `published` = verified, locked, PDF generated, teacher notified |
| return_reason | text, nullable | set when principal sends it back to admin for correction (status reverts to `draft`) |
| created_by | FK → users | admin who keyed in the salary data |
| submitted_at | timestamp, nullable | when admin submitted it for principal review |
| reviewed_by | FK → users, nullable | principal who verified/published (or returned) it |
| reviewed_at | timestamp, nullable | |
| notified_at | timestamp, nullable | set when status moves to `published` |

**Media collection**: `pdf` (the generated mPDF file, attached once `published`).

Same review-cycle shape as `children` (draft → submitted → approved/returned) — kept consistent rather than inventing a different pattern for payroll.

## Relationships Summary

```
users 1―1 staff_profiles
users 1―1 leave_balances
users 1―N leave_applications (as staff_id)
users 1―N leave_applications (as reviewed_by)
users 1―N children (as created_by)
users 1―N children (as reviewed_by)
users 1―N job_applications (as reviewed_by)
users 1―1 job_applications (as created_user_id, nullable)
users 1―N payslips (as staff_id, the recipient)
users 1―N payslips (as created_by, admin)
users 1―N payslips (as reviewed_by, principal)
children 1―2 child_guardians (father, mother)
children 1―N child_illnesses ―N―1 ref_illnesses
children 1―N child_health_issues ―N―1 ref_health_issues

staff_profiles 1―1 addresses (morph)
children 1―1 addresses (morph)
job_applications 1―1 addresses (morph)
ref_states 1―N addresses

ref_departments 1―N staff_profiles
ref_banks 1―N staff_profiles
ref_genders 1―N children, job_applications, staff_profiles
ref_religions 1―N children, child_guardians, job_applications, staff_profiles
ref_races 1―N children, child_guardians, job_applications, staff_profiles
ref_countries 1―N children, child_guardians (nationality)
ref_countries 1―N ref_states
ref_marital_statuses 1―N child_guardians, job_applications, staff_profiles
ref_leave_types 1―N leave_applications
```
