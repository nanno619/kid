<?php

namespace App\Models;

use App\Models\Concerns\HasUlid;
use Database\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
    'address_line_1',
    'address_line_2',
    'address_line_3',
    'state_id',
    'district',
    'city',
    'postcode',
])]
class Address extends Model
{
    /** @use HasFactory<AddressFactory> */
    use HasFactory, HasUlid;

    /**
     * @return MorphTo<Model, $this>
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo<RefState, $this>
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(RefState::class, 'state_id');
    }
}
