<?php

namespace App\Models;

use App\Models\Concerns\HasUlid;
use Database\Factories\StaffProfileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

#[Fillable([
    'staff_number',
    'full_name',
    'ic_number',
    'date_of_birth',
    'gender_id',
    'race_id',
    'religion_id',
    'marital_status_id',
    'mobile_number',
    'siblings_count',
    'education_level',
    'ambition',
    'field_experience',
    'previous_work_experience',
    'reason_left_previous_job',
    'has_mental_illness',
    'illness_details',
    'family_member_name',
    'family_member_ic',
    'family_member_occupation',
    'family_member_employer_address',
    'family_member_phone',
    'epf_number',
    'department_id',
    'bank_id',
    'bank_account_number',
])]
class StaffProfile extends Model
{
    /** @use HasFactory<StaffProfileFactory> */
    use HasFactory, HasUlid;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'has_mental_illness' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<RefGender, $this>
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(RefGender::class, 'gender_id');
    }

    /**
     * @return BelongsTo<RefRace, $this>
     */
    public function race(): BelongsTo
    {
        return $this->belongsTo(RefRace::class, 'race_id');
    }

    /**
     * @return BelongsTo<RefReligion, $this>
     */
    public function religion(): BelongsTo
    {
        return $this->belongsTo(RefReligion::class, 'religion_id');
    }

    /**
     * @return BelongsTo<RefMaritalStatus, $this>
     */
    public function maritalStatus(): BelongsTo
    {
        return $this->belongsTo(RefMaritalStatus::class, 'marital_status_id');
    }

    /**
     * @return BelongsTo<RefDepartment, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(RefDepartment::class, 'department_id');
    }

    /**
     * @return BelongsTo<RefBank, $this>
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(RefBank::class, 'bank_id');
    }

    /**
     * @return MorphOne<Address, $this>
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
