<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'location',
        'genre',
        'event_date',
        'image',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'event_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Curated Unsplash images related to music, concerts, and live performances.
     */
    private static array $unsplashImages = [
        'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&h=400&fit=crop', // guitar closeup
        'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=600&h=400&fit=crop', // concert crowd
        'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600&h=400&fit=crop', // dj performing
        'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=600&h=400&fit=crop', // music studio
        'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?w=600&h=400&fit=crop', // concert lights
        'https://images.unsplash.com/photo-1524368535928-5b5e00ddc76b?w=600&h=400&fit=crop', // live show audience
        'https://images.unsplash.com/photo-1501612780327-45045538702b?w=600&h=400&fit=crop', // concert stage
        'https://images.unsplash.com/photo-1415201364774-f6f0bb35f28f?w=600&h=400&fit=crop', // vinyl records
        'https://images.unsplash.com/photo-1507838153414-b4b713384a76?w=600&h=400&fit=crop', // piano keys
        'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=600&h=400&fit=crop', // singer on stage
        'https://images.unsplash.com/photo-1485579149621-3123dd979885?w=600&h=400&fit=crop', // microphone
        'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?w=600&h=400&fit=crop', // music mixing
    ];

    public function getImageUrl(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        // Deterministic pick based on announcement id
        $index = $this->id % count(self::$unsplashImages);
        return self::$unsplashImages[$index];
    }

    public function getFormattedPrice(): string
    {
        if ($this->price) {
            return 'R$' . number_format($this->price, 0, ',', '.');
        }
        return 'A combinar';
    }

    /**
     * Check if the event date has already passed.
     */
    public function isExpired(): bool
    {
        if (!$this->event_date) {
            return false;
        }
        return $this->event_date->endOfDay()->isPast();
    }

    /**
     * Return a human-friendly formatted event date.
     */
    public function getFormattedEventDate(): ?string
    {
        if (!$this->event_date) {
            return null;
        }
        return $this->event_date->format('d/m/Y');
    }
}
