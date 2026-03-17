<?php

namespace App\Models;

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
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrl(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('img/placeholder.svg');
    }

    public function getFormattedPrice(): string
    {
        if ($this->price) {
            return 'R$' . number_format($this->price, 0, ',', '.');
        }
        return 'A combinar';
    }
}
