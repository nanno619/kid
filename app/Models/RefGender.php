<?php

namespace App\Models;

use Database\Factories\RefGenderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]
class RefGender extends Model
{
    /** @use HasFactory<RefGenderFactory> */
    use HasFactory;
}
