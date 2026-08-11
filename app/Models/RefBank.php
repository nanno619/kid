<?php

namespace App\Models;

use Database\Factories\RefBankFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]
class RefBank extends Model
{
    /** @use HasFactory<RefBankFactory> */
    use HasFactory;
}
