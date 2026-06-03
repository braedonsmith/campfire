<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'issued_to', 'capid');
    }

    public function vehicleInspections(): HasMany
    {
        return $this->hasMany(VehicleInspection::class, 'inspector_capid', 'capid');
    }

    public function vehicleInspectionsOverridden(): HasMany
    {
        return $this->hasMany(VehicleInspection::class, 'ic_capid', 'capid');
    }

    public function radios(): HasMany
    {
        return $this->hasMany(Radio::class, 'issued_to', 'capid');
    }

    public function headcounts(): HasManyThrough
    {
        return $this->hasManyThrough(Headcount::class, HeadcountEntry::class, 'capid', 'id', 'headcount_id', 'capid');
    }

    public function blocksFacilitated(): HasMany
    {
        return $this->hasMany(ScheduleBlock::class, 'facilitator_capid', 'capid');
    }

    public function kanbanItemsAssigned(): HasMany
    {
        return $this->hasMany(KanbanItem::class, 'assignee_capid', 'capid');
    }

    public function kanbanItemsCreated(): HasMany
    {
        return $this->hasMany(KanbanItem::class, 'creator_capid', 'capid');
    }

    public function dutyPositions(): BelongsToMany
    {
        return $this->belongsToMany(DutyPosition::class)->using(DutyAssignment::class);
    }

    public function unit(): HasOneThrough
    {
        return $this->hasOneThrough(Unit::class, DutyAssignment::class, 'unit_id', 'capid', 'id', 'id');
    }
}
