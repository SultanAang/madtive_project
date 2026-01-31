<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KnowledgeBase extends Model
{
    use HasFactory;
    
    // Tambahkan ini agar bisa simpan data!

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    protected $guarded = []; 
}