<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model {
    use HasFactory;

    // Tambahkan baris ini!
    // Artinya: "Tidak ada kolom yang dijaga ketat, silakan isi semuanya."
    protected $guarded = [];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
