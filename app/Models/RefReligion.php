<?php

namespace App\Models;

use Database\Factories\RefReligionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]
class RefReligion extends Model
{
    /** @use HasFactory<RefReligionFactory> */
    use HasFactory;
}
