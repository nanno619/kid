<?php

namespace App\Models;

use Database\Factories\RefRaceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]
class RefRace extends Model
{
    /** @use HasFactory<RefRaceFactory> */
    use HasFactory;
}
