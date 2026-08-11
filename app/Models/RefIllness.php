<?php

namespace App\Models;

use Database\Factories\RefIllnessFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]
class RefIllness extends Model
{
    /** @use HasFactory<RefIllnessFactory> */
    use HasFactory;
}
