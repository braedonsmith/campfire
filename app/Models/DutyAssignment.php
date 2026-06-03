<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'office_symbol', 'only_one', 'senior_only', 'next_higher_id'])]
class DutyAssignment extends Model
{
    //
}
