<?php

namespace App\Models;

use Database\Factories\RefMaritalStatusFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]
class RefMaritalStatus extends Model
{
    /** @use HasFactory<RefMaritalStatusFactory> */
    use HasFactory;
}
