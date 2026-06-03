<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Radio extends Model
{
    public function type(): BelongsTo
    {
        return $this->belongsTo(RadioType::class);
    }

    public function holder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_to', 'capid');
    }
}
