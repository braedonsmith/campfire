<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KanbanItem extends Model
{
    protected $guarded = ['id', 'created_at','updated_at'];

    protected $casts = [
        'due_by' => 'datetime'
    ];

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_capid', 'capid');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_capid', 'capid');
    }
}
