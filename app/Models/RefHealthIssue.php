<?php

namespace App\Models;

use Database\Factories\RefHealthIssueFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]
class RefHealthIssue extends Model
{
    /** @use HasFactory<RefHealthIssueFactory> */
    use HasFactory;
}
