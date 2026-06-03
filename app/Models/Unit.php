<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

#[Table(timestamps: false)]
class Unit extends Model
{
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Unit::class, 'parent_id', 'id');
    }

    public function members(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, DutyAssignment::class, 'capid', 'capid', 'unit_id', 'id');
    }
}
