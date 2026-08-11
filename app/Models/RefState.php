<?php

namespace App\Models;

use Database\Factories\RefStateFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'country_id'])]
class RefState extends Model
{
    /** @use HasFactory<RefStateFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<RefCountry, $this>
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(RefCountry::class, 'country_id');
    }
}
