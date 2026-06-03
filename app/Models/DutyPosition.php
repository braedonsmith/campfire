<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Table(timestamps: false)]
class DutyPosition extends Model
{
    public function positionHolders(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(DutyAssignment::class);
    }
}
