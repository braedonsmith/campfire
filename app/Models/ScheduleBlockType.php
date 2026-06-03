<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table(timestamps: false)]
class ScheduleBlockType extends Model
{
    public function blocks(): HasMany
    {
        return $this->hasMany(ScheduleBlock::class);
    }
}
