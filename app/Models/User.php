<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function musicianProfile(): HasOne
    {
        return $this->hasOne(MusicianProfile::class);
    }

    public function establishmentProfile(): HasOne
    {
        return $this->hasOne(EstablishmentProfile::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewed_user_id');
    }

    public function reviewsGiven(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function isMusician(): bool
    {
        return $this->type === 'musician';
    }

    public function isEstablishment(): bool
    {
        return $this->type === 'establishment';
    }

    public function getDisplayName(): string
    {
        if ($this->isMusician() && $this->musicianProfile) {
            return trim($this->musicianProfile->first_name . ' ' . $this->musicianProfile->last_name) ?: $this->name;
        }
        if ($this->isEstablishment() && $this->establishmentProfile) {
            return $this->establishmentProfile->establishment_name ?: $this->name;
        }
        return $this->name;
    }

    public function getAvatarUrl(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return asset('img/default-avatar.svg');
    }
}
