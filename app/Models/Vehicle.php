<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    public function type(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function key_holder(): HasOne
    {
        return $this->hasOne(User::class, 'capid', 'issued_to');
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(VehicleInspection::class);
    }
}
