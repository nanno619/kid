<?php

namespace App\DataTransferObjects;

use App\Http\Requests\StoreStaffProfileRequest;
use App\Models\StaffProfile;

final readonly class StaffProfileData
{
    public function __construct(
        public string $staffNumber,
        public string $fullName,
        public string $icNumber,
        public string $dateOfBirth,
        public int $genderId,
        public int $raceId,
        public int $religionId,
        public ?int $maritalStatusId,
        public string $mobileNumber,
        public ?int $siblingsCount,
        public ?string $educationLevel,
        public ?string $ambition,
        public ?string $fieldExperience,
        public ?string $previousWorkExperience,
        public ?string $reasonLeftPreviousJob,
        public ?bool $hasMentalIllness,
        public ?string $illnessDetails,
        public ?string $familyMemberName,
        public ?string $familyMemberIc,
        public ?string $familyMemberOccupation,
        public ?string $familyMemberEmployerAddress,
        public ?string $familyMemberPhone,
        public ?string $epfNumber,
        public ?int $departmentId,
        public ?int $bankId,
        public ?string $bankAccountNumber,
    ) {}

    public static function fromRequest(StoreStaffProfileRequest $request): self
    {
        $data = $request->safe()->except('address');

        return new self(
            staffNumber: $data['staff_number'],
            fullName: $data['full_name'],
            icNumber: $data['ic_number'],
            dateOfBirth: $data['date_of_birth'],
            genderId: $data['gender_id'],
            raceId: $data['race_id'],
            religionId: $data['religion_id'],
            maritalStatusId: $data['marital_status_id'] ?? null,
            mobileNumber: $data['mobile_number'],
            siblingsCount: $data['siblings_count'] ?? null,
            educationLevel: $data['education_level'] ?? null,
            ambition: $data['ambition'] ?? null,
            fieldExperience: $data['field_experience'] ?? null,
            previousWorkExperience: $data['previous_work_experience'] ?? null,
            reasonLeftPreviousJob: $data['reason_left_previous_job'] ?? null,
            hasMentalIllness: $data['has_mental_illness'] ?? null,
            illnessDetails: $data['illness_details'] ?? null,
            familyMemberName: $data['family_member_name'] ?? null,
            familyMemberIc: $data['family_member_ic'] ?? null,
            familyMemberOccupation: $data['family_member_occupation'] ?? null,
            familyMemberEmployerAddress: $data['family_member_employer_address'] ?? null,
            familyMemberPhone: $data['family_member_phone'] ?? null,
            epfNumber: $data['epf_number'] ?? null,
            departmentId: $data['department_id'] ?? null,
            bankId: $data['bank_id'] ?? null,
            bankAccountNumber: $data['bank_account_number'] ?? null,
        );
    }

    /**
     * Staff number, EPF number, department, and bank details are administrative
     * fields the principal fills in after hire (per Backend Schema) — a teacher
     * editing their own profile can't change them, regardless of what was
     * submitted, so this locks them back to the profile's current values.
     */
    public function withAdminFieldsFrom(StaffProfile $current): self
    {
        return new self(
            staffNumber: $current->staff_number,
            fullName: $this->fullName,
            icNumber: $this->icNumber,
            dateOfBirth: $this->dateOfBirth,
            genderId: $this->genderId,
            raceId: $this->raceId,
            religionId: $this->religionId,
            maritalStatusId: $this->maritalStatusId,
            mobileNumber: $this->mobileNumber,
            siblingsCount: $this->siblingsCount,
            educationLevel: $this->educationLevel,
            ambition: $this->ambition,
            fieldExperience: $this->fieldExperience,
            previousWorkExperience: $this->previousWorkExperience,
            reasonLeftPreviousJob: $this->reasonLeftPreviousJob,
            hasMentalIllness: $this->hasMentalIllness,
            illnessDetails: $this->illnessDetails,
            familyMemberName: $this->familyMemberName,
            familyMemberIc: $this->familyMemberIc,
            familyMemberOccupation: $this->familyMemberOccupation,
            familyMemberEmployerAddress: $this->familyMemberEmployerAddress,
            familyMemberPhone: $this->familyMemberPhone,
            epfNumber: $current->epf_number,
            departmentId: $current->department_id,
            bankId: $current->bank_id,
            bankAccountNumber: $current->bank_account_number,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'staff_number' => $this->staffNumber,
            'full_name' => $this->fullName,
            'ic_number' => $this->icNumber,
            'date_of_birth' => $this->dateOfBirth,
            'gender_id' => $this->genderId,
            'race_id' => $this->raceId,
            'religion_id' => $this->religionId,
            'marital_status_id' => $this->maritalStatusId,
            'mobile_number' => $this->mobileNumber,
            'siblings_count' => $this->siblingsCount,
            'education_level' => $this->educationLevel,
            'ambition' => $this->ambition,
            'field_experience' => $this->fieldExperience,
            'previous_work_experience' => $this->previousWorkExperience,
            'reason_left_previous_job' => $this->reasonLeftPreviousJob,
            'has_mental_illness' => $this->hasMentalIllness,
            'illness_details' => $this->illnessDetails,
            'family_member_name' => $this->familyMemberName,
            'family_member_ic' => $this->familyMemberIc,
            'family_member_occupation' => $this->familyMemberOccupation,
            'family_member_employer_address' => $this->familyMemberEmployerAddress,
            'family_member_phone' => $this->familyMemberPhone,
            'epf_number' => $this->epfNumber,
            'department_id' => $this->departmentId,
            'bank_id' => $this->bankId,
            'bank_account_number' => $this->bankAccountNumber,
        ];
    }
}
