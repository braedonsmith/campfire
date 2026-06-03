<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table(timestamps: false)]
class RadioType extends Model
{
    public function radios(): HasMany
    {
        return $this->hasMany(Radio::class);
    }
}
