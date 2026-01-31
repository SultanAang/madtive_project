<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Filament\Models\Contracts\HasTenants;

class Roadmap extends Model {
    use HasFactory;
    protected $guarded = []; // <--- TAMBAHKAN INI

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
