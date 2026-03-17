<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstablishmentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'establishment_name',
        'cnpj',
        'website',
        'state',
        'city',
        'cep',
        'address',
        'about',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
