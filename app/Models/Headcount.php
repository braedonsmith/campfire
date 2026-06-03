<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Headcount extends Model
{
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function attendees(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, HeadcountEntry::class, 'headcount_id', 'capid', 'id', 'capid');
    }
}
