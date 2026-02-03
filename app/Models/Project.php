<?php

namespace App\Models;

use App\Livewire\ReleaseNotes;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Models\Contracts\HasName;

class Project extends Model implements HasName {
    protected $fillable = [
        "client_id",
        "name",
        "slug",
        "logo",
        "description",
        "deadline",
        "status",
        "progress",
    ];

    protected $guarded = [];

    public function getFilamentName(): string {
        return $this->name;
    }

    public function client() {
        // Pastikan Model Client atau User sesuai dengan aplikasi Anda
        return $this->belongsTo(Client::class);
    }
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    // Project punya banyak Roadmap
    public function roadmaps(): HasMany {
        return $this->hasMany(Roadmap::class);
    }

    public function faqs(): HasMany {
        return $this->hasMany(Faq::class);
    }

    public function knowledge(): HasMany {
        return $this->hasMany(KnowledgeBase::class);
    }

    public function releases(): HasMany {
        return $this->hasMany(Release::class);
    }
    public function bugReports() {
        return $this->hasMany(BugReport::class);
    }
}
