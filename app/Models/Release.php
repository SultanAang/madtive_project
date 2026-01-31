<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Release extends Model
{
    // 1. Izinkan kita mengisi semua kolom secara massal (lewat Filament)
    protected $guarded = [];

    // 2. Casting (Penerjemah Data)
    protected $casts = [
        'features' => 'array',       // JSON Database -> Array PHP
        'published_at' => 'date',    // String Tanggal -> Objek Tanggal
        'is_visible' => 'boolean',   // 1/0 -> True/False
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}