<?php

namespace App\Models;

use Database\Factories\RefCountryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
class RefCountry extends Model
{
    /** @use HasFactory<RefCountryFactory> */
    use HasFactory;

    /**
     * @return HasMany<RefState, $this>
     */
    public function states(): HasMany
    {
        return $this->hasMany(RefState::class, 'country_id');
    }
}
