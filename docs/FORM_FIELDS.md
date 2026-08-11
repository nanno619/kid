# Hardcopy Form Fields (Raw Reference)

Field-by-field transcription of the kindergarten's paper forms, provided by the user. This is source material for the Backend Schema doc — field names here are kept close to the original (mixed English/Malay) rather than normalized, so nothing is lost in translation. Data types, validation, and exact column names get decided in the Backend Schema doc.

## 1. Children Registration

### Section A: Keterangan Anak (Child Details)
- Full Name (capital letters)
- No. Kad Pengenalan (IC number)
- Birth Certificate
- Date of Birth
- Age
- Jantina (Gender)
- Religion
- Race
- Nationality
- Mailing Address

### Section B: Keterangan Ibubapa/Penjaga (Parent/Guardian Details)

**Maklumat Bapa (Father's Info)**
- Full Name (capital letters)
- No. Kad Pengenalan
- Date of Birth
- Race
- Religion
- Nationality
- Taraf Perkahwinan (Marital Status)
- No. Telefon Rumah (Home Phone)
- Mobile Number
- Office Number
- Email
- Nama Jawatan dan Alamat Majikan (Job Title & Employer Address)

**Maklumat Ibu (Mother's Info)** — same fields as father:
- Full Name (capital letters)
- No. Kad Pengenalan
- Date of Birth
- Race
- Religion
- Nationality
- Taraf Perkahwinan
- No. Telefon Rumah
- Mobile Number
- Office Number
- Email
- Nama Jawatan dan Alamat Majikan

### Section C: Latar Belakang Kesihatan Anak (Child's Health Background)

Checkbox — Nama Penyakit (Illness):
- Lelah (Asthma)
- Batuk Kering (TB)
- Sakit Jantung (Heart disease)
- Gastrik
- Barah (Cancer)
- Sawan (Seizures)
- Lain-lain (Other — please specify)

Checkbox — Masalah (Issues):
- Cepat Penat (Easily tired)
- Sakit Dada (Chest pain)
- Selalu Pitam/Pening Kepala (Frequent fainting/dizziness)
- Kurang Penglihatan (Poor vision)
- Kurang Pendengaran (Poor hearing)
- Alahan (Allergies — please specify if any)
- Lain-lain (Other — please specify)

- Adakah anak anda mengalami kecacatan? (Does your child have a disability?) — Yes (please specify) / No

### Section D: Pengakuan Ibubapa/Penjaga (Parent/Guardian Declaration)
- Parent's signature
- Principal's signature

### Attachments
- Salinan Sijil Kelahiran (Birth certificate copy)
- Salinan Kad Pengenalan Bapa (Father's IC copy)
- Salinan Kad Pengenalan Ibu (Mother's IC copy)
- Salinan Buku Kesihatan Kanak-kanak / Buku Imunisasi (Child health/immunization booklet copy)
- Salinan Slip Gaji Terkini Ibu dan Ayah (Latest payslip copy — both parents)
- Salinan Vaksin COVID-19 Ibu & Ayah (wajib) dan Anak (jika ada) (COVID-19 vaccination copy — parents mandatory, child if applicable)

## 2. Teacher Profile

- Full Name (capital letters)
- No. Kad Pengenalan
- Age
- Date of Birth
- Mobile Number
- Address
- No. KWSP (EPF No.)

## 3. Job Application

### Section A: Maklumat Pemohon (Applicant Info)
- Applicant Name
- Gender
- Date of Birth
- Age
- Race
- Religion
- No. of Siblings
- Home Address
- Mobile Number
- Education Level
- Ambition
- Status (Single/Married)
- Pengalaman dalam Bidang yang Dipohon (Experience in the field applied for)
- Pengalaman Kerja Sebelum Ini (Previous work experience)
- Sebab Berhenti Kerja Sebelum Ini (Reason for leaving previous job)
- Ada Penyakit Mental? (Any mental illness?)
- Ada Penyakit (Jika YA, sila nyatakan) (Any illness — if yes, specify)

### Section B: Maklumat Keluarga (Family Info)
- Nama Suami/Bapa (Husband's/Father's Name)
- No. Kad Pengenalan
- Pekerjaan (Occupation)
- Nama & Alamat Majikan (Employer Name & Address)
- No. Telefon

## 4. Leave Application

- Type of Leave (checkbox):
  - Cuti Tahunan (Annual Leave)
  - Cuti Kecemasan (Emergency Leave)
  - Cuti Tanpa Gaji (Unpaid Leave)
  - Cuti Ganti (Replacement Leave)
  - Cuti Sakit (Sick Leave)
  - Cuti Lain-lain (Other Leave)
- Name
- Jawatan (Role/Position)
- Bahagian (Department) — Playschool / Babyschool
- No. Staff (Staff Number)
- Tarikh Cuti Dipohon (Dari/Hingga) (Requested Leave Dates — From/To)
- Duration
- Sebab Cuti (Reason for Leave)

## Resolved

- Only Cuti Tahunan (Annual Leave) draws down the 8-day quota. Cuti Kecemasan, Cuti Tanpa Gaji, Cuti Ganti, Cuti Sakit, and Cuti Lain-lain are tracked as requests but don't affect the balance.

## Open Questions

- "Playschool / Babyschool" under Bahagian — is this a fixed two-option field, or should it be a general department/class field?
