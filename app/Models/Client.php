<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {
    protected $fillable = ["user_id", "company_name", "address", "phone", "logo"];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function project() {
        return $this->hasOne(Project::class);
    }
}
