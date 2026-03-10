<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['nom', 'description'];

    public function livre() {
        return $this->belongsTo(Livre::class);
    }
}
