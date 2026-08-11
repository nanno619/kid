<?php

namespace App\Models;

use Database\Factories\RefDepartmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]
class RefDepartment extends Model
{
    /** @use HasFactory<RefDepartmentFactory> */
    use HasFactory;
}
