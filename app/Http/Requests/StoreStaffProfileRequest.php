<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStaffProfileRequest extends FormRequest
{
    /**
     * Authorization is handled by the #[Authorize] attribute on the controller
     * action, not here — this request only validates shape/format.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $staffProfile = $this->route('staffProfile') ?? $this->user()->staffProfile;

        return [
            'staff_number' => ['required', 'string', 'max:255', Rule::unique('staff_profiles', 'staff_number')->ignore($staffProfile?->id)],
            'full_name' => ['required', 'string', 'max:255'],
            'ic_number' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date'],
            'gender_id' => ['required', Rule::exists('ref_genders', 'id')],
            'race_id' => ['required', Rule::exists('ref_races', 'id')],
            'religion_id' => ['required', Rule::exists('ref_religions', 'id')],
            'marital_status_id' => ['nullable', Rule::exists('ref_marital_statuses', 'id')],
            'mobile_number' => ['required', 'string', 'max:20'],
            'siblings_count' => ['nullable', 'integer', 'min:0'],
            'education_level' => ['nullable', 'string', 'max:255'],
            'ambition' => ['nullable', 'string', 'max:255'],
            'field_experience' => ['nullable', 'string'],
            'previous_work_experience' => ['nullable', 'string'],
            'reason_left_previous_job' => ['nullable', 'string'],
            'has_mental_illness' => ['nullable', 'boolean'],
            'illness_details' => ['nullable', 'string'],
            'family_member_name' => ['nullable', 'string', 'max:255'],
            'family_member_ic' => ['nullable', 'string', 'max:20'],
            'family_member_occupation' => ['nullable', 'string', 'max:255'],
            'family_member_employer_address' => ['nullable', 'string'],
            'family_member_phone' => ['nullable', 'string', 'max:20'],
            'epf_number' => ['nullable', 'string', 'max:255'],
            'department_id' => ['nullable', Rule::exists('ref_departments', 'id')],
            'bank_id' => ['nullable', Rule::exists('ref_banks', 'id')],
            'bank_account_number' => ['nullable', 'string', 'max:255'],

            'address.address_line_1' => ['required', 'string', 'max:255'],
            'address.address_line_2' => ['nullable', 'string', 'max:255'],
            'address.address_line_3' => ['nullable', 'string', 'max:255'],
            'address.state_id' => ['nullable', Rule::exists('ref_states', 'id')],
            'address.district' => ['nullable', 'string', 'max:255'],
            'address.city' => ['nullable', 'string', 'max:255'],
            'address.postcode' => ['nullable', 'string', 'max:20'],
        ];
    }
}
