@props(['staffProfile', 'adminFieldsEditable' => false])

@php
    $genders = \App\Models\RefGender::orderBy('name')->get();
    $races = \App\Models\RefRace::orderBy('name')->get();
    $religions = \App\Models\RefReligion::orderBy('name')->get();
    $maritalStatuses = \App\Models\RefMaritalStatus::orderBy('name')->get();
    $departments = \App\Models\RefDepartment::orderBy('name')->get();
    $banks = \App\Models\RefBank::orderBy('name')->get();
    $states = \App\Models\RefState::orderBy('name')->get();
    $address = $staffProfile->address;
@endphp

<div class="row row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Personal Information</h3>
            </div>
            <div class="card-body">
                <fieldset class="form-fieldset">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Full Name</label>
                            <input type="text" name="full_name" value="{{ old('full_name', $staffProfile->full_name) }}"
                                class="form-control @error('full_name') is-invalid @enderror">
                            @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">No. Kad Pengenalan</label>
                            <input type="text" name="ic_number" value="{{ old('ic_number', $staffProfile->ic_number) }}"
                                class="form-control @error('ic_number') is-invalid @enderror">
                            @error('ic_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Date of Birth</label>
                            <input type="date" name="date_of_birth"
                                value="{{ old('date_of_birth', optional($staffProfile->date_of_birth)->format('Y-m-d')) }}"
                                class="form-control @error('date_of_birth') is-invalid @enderror">
                            @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Mobile Number</label>
                            <input type="text" name="mobile_number" value="{{ old('mobile_number', $staffProfile->mobile_number) }}"
                                class="form-control @error('mobile_number') is-invalid @enderror">
                            @error('mobile_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">Gender</label>
                            <select name="gender_id" class="form-select @error('gender_id') is-invalid @enderror">
                                <option value="">Select...</option>
                                @foreach ($genders as $gender)
                                    <option value="{{ $gender->id }}" @selected(old('gender_id', $staffProfile->gender_id) == $gender->id)>{{ $gender->name }}</option>
                                @endforeach
                            </select>
                            @error('gender_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">Race</label>
                            <select name="race_id" class="form-select @error('race_id') is-invalid @enderror">
                                <option value="">Select...</option>
                                @foreach ($races as $race)
                                    <option value="{{ $race->id }}" @selected(old('race_id', $staffProfile->race_id) == $race->id)>{{ $race->name }}</option>
                                @endforeach
                            </select>
                            @error('race_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">Religion</label>
                            <select name="religion_id" class="form-select @error('religion_id') is-invalid @enderror">
                                <option value="">Select...</option>
                                @foreach ($religions as $religion)
                                    <option value="{{ $religion->id }}" @selected(old('religion_id', $staffProfile->religion_id) == $religion->id)>{{ $religion->name }}</option>
                                @endforeach
                            </select>
                            @error('religion_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Taraf Perkahwinan</label>
                            <select name="marital_status_id" class="form-select @error('marital_status_id') is-invalid @enderror">
                                <option value="">Select...</option>
                                @foreach ($maritalStatuses as $status)
                                    <option value="{{ $status->id }}" @selected(old('marital_status_id', $staffProfile->marital_status_id) == $status->id)>{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('marital_status_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Employment Information</h3>
            </div>
            <div class="card-body">
                <fieldset class="form-fieldset">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">No. Staff</label>
                            @if ($adminFieldsEditable)
                                <input type="text" name="staff_number" value="{{ old('staff_number', $staffProfile->staff_number) }}"
                                    class="form-control @error('staff_number') is-invalid @enderror">
                                @error('staff_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @else
                                <input type="text" value="{{ $staffProfile->staff_number }}" class="form-control" disabled>
                                <input type="hidden" name="staff_number" value="{{ $staffProfile->staff_number }}">
                            @endif
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">No. KWSP (EPF)</label>
                            @if ($adminFieldsEditable)
                                <input type="text" name="epf_number" value="{{ old('epf_number', $staffProfile->epf_number) }}"
                                    class="form-control @error('epf_number') is-invalid @enderror">
                                @error('epf_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @else
                                <input type="text" value="{{ $staffProfile->epf_number }}" class="form-control" disabled>
                            @endif
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bahagian (Department)</label>
                            @if ($adminFieldsEditable)
                                <select name="department_id" class="form-select @error('department_id') is-invalid @enderror">
                                    <option value="">Select...</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" @selected(old('department_id', $staffProfile->department_id) == $department->id)>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @else
                                <input type="text" value="{{ $staffProfile->department?->name }}" class="form-control" disabled>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bank Name</label>
                            @if ($adminFieldsEditable)
                                <select name="bank_id" class="form-select @error('bank_id') is-invalid @enderror">
                                    <option value="">Select...</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}" @selected(old('bank_id', $staffProfile->bank_id) == $bank->id)>{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                                @error('bank_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @else
                                <input type="text" value="{{ $staffProfile->bank?->name }}" class="form-control" disabled>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account No.</label>
                            @if ($adminFieldsEditable)
                                <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $staffProfile->bank_account_number) }}"
                                    class="form-control @error('bank_account_number') is-invalid @enderror">
                                @error('bank_account_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @else
                                <input type="text" value="{{ $staffProfile->bank_account_number }}" class="form-control" disabled>
                            @endif
                        </div>
                    </div>
                    @unless ($adminFieldsEditable)
                        <p class="form-hint mb-0">No. Staff, EPF, Bahagian, and Bank details are managed by the principal.</p>
                    @endunless
                </fieldset>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Address</h3>
            </div>
            <div class="card-body">
                <fieldset class="form-fieldset">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label required">Address 1</label>
                            <input type="text" name="address[address_line_1]" value="{{ old('address.address_line_1', $address?->address_line_1) }}"
                                class="form-control @error('address.address_line_1') is-invalid @enderror">
                            @error('address.address_line_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Address 2</label>
                            <input type="text" name="address[address_line_2]" value="{{ old('address.address_line_2', $address?->address_line_2) }}"
                                class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Address 3</label>
                            <input type="text" name="address[address_line_3]" value="{{ old('address.address_line_3', $address?->address_line_3) }}"
                                class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">District</label>
                            <input type="text" name="address[district]" value="{{ old('address.district', $address?->district) }}" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="address[city]" value="{{ old('address.city', $address?->city) }}" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">State</label>
                            <select name="address[state_id]" class="form-select">
                                <option value="">Select...</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" @selected(old('address.state_id', $address?->state_id) == $state->id)>{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Postcode</label>
                            <input type="text" name="address[postcode]" value="{{ old('address.postcode', $address?->postcode) }}" class="form-control">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recruitment Background</h3>
            </div>
            <div class="card-body">
                <fieldset class="form-fieldset">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">No. of Siblings</label>
                            <input type="number" min="0" name="siblings_count" value="{{ old('siblings_count', $staffProfile->siblings_count) }}" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Education Level</label>
                            <input type="text" name="education_level" value="{{ old('education_level', $staffProfile->education_level) }}" class="form-control">
                        </div>
                        <div class="col-md-5 mb-3">
                            <label class="form-label">Ambition</label>
                            <input type="text" name="ambition" value="{{ old('ambition', $staffProfile->ambition) }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pengalaman dalam Bidang yang Dipohon</label>
                            <textarea name="field_experience" class="form-control" rows="2">{{ old('field_experience', $staffProfile->field_experience) }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pengalaman Kerja Sebelum Ini</label>
                            <textarea name="previous_work_experience" class="form-control" rows="2">{{ old('previous_work_experience', $staffProfile->previous_work_experience) }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Sebab Berhenti Kerja Sebelum Ini</label>
                            <textarea name="reason_left_previous_job" class="form-control" rows="2">{{ old('reason_left_previous_job', $staffProfile->reason_left_previous_job) }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-check">
                                <input type="hidden" name="has_mental_illness" value="0">
                                <input type="checkbox" class="form-check-input" name="has_mental_illness" value="1"
                                    @checked(old('has_mental_illness', $staffProfile->has_mental_illness))>
                                <span class="form-check-label">Ada penyakit mental?</span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Ada Penyakit (jika ada, sila nyatakan)</label>
                            <textarea name="illness_details" class="form-control" rows="2">{{ old('illness_details', $staffProfile->illness_details) }}</textarea>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Family / Emergency Contact</h3>
            </div>
            <div class="card-body">
                <fieldset class="form-fieldset">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Suami/Bapa</label>
                            <input type="text" name="family_member_name" value="{{ old('family_member_name', $staffProfile->family_member_name) }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Kad Pengenalan</label>
                            <input type="text" name="family_member_ic" value="{{ old('family_member_ic', $staffProfile->family_member_ic) }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="family_member_occupation" value="{{ old('family_member_occupation', $staffProfile->family_member_occupation) }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telefon</label>
                            <input type="text" name="family_member_phone" value="{{ old('family_member_phone', $staffProfile->family_member_phone) }}" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nama & Alamat Majikan</label>
                            <textarea name="family_member_employer_address" class="form-control" rows="2">{{ old('family_member_employer_address', $staffProfile->family_member_employer_address) }}</textarea>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="btn-list">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
