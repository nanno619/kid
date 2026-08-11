# Product Requirements Document (PRD)

## Overview

Kidner digitizes the day-to-day administrative paperwork of a small kindergarten, replacing hardcopy forms and manual filing with a single system. The kindergarten currently manages children's registration, staff records, job applications, leave requests, and payslips entirely on paper.

## Problem

The kindergarten's admin records — children applications, staff/teacher profiles, job applications, leave requests, payslips — are all paper-based. This makes records hard to search, easy to lose, slow to process (e.g. approvals), and error-prone (e.g. manual payslip calculation).

## Goals

- Replace the five paper workflows below with digital equivalents.
- Give the principal a way to review and approve leave requests and job applications without physical paperwork.
- Generate payslips from the system instead of preparing them manually.
- Keep the system simple enough for non-technical staff (teachers, principal) to use directly.

## Target Users

- **Principal** — full oversight; reviews and approves children registration, job applications, leave requests, and payslips.
- **Admin** — handles day-to-day data entry: children registration (from hardcopy submissions), staff/teacher profile management, job application processing, and keying in payslip/salary data — all subject to principal review/approval.
- **Teacher** — narrow scope: manages their own profile, submits their own leave requests, and views their own payslips. Does not touch children registration, other staff records, or job applications.
- **Parent** *(Phase 2 — not in v1)* — will eventually log in to submit children registration directly instead of handing in paper.

## Core Features (V1 — build all five together)

### 1. Children Registration
Digitizes the paper children application form. Admin transcribes hardcopy submissions into the system; principal reviews and approves. Replaces physical filing of child records.

### 2. Staff / Teacher Profiles
Digitizes the teacher info profile. Stores each staff member's personal and employment details in one place instead of paper files.

### 3. Job Applications
Digitizes the job application form filled out by prospective teachers. Principal reviews submitted applications and approves or rejects them in-app.

### 4. Leave Applications
Digitizes the leave application form. Teachers submit their own leave requests; admin can view requests/balances across staff; principal reviews and approves/rejects.

### 5. Payslips
System generates staff payslips (replacing manual preparation). Payslip template/layout to be designed separately (see Design Brief). Admin keys in salary data; principal reviews and publishes; teacher can view their own published payslips.

## Out of Scope (V1)

- Parent login/portal for self-submitting children registration — deferred to Phase 2.
- Payslip template/design — placeholder in v1, finalized in the Design Brief.
- Payroll calculation rules (tax, deductions, etc.) — to be defined before the Backend Schema/Engineering Plan lock in the payslip feature.

## Open Questions / Inputs Needed

- Payslip PDF template — payslip calculation structure is settled (see Backend Schema), the visual template is still pending.
