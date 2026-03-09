<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    protected $fillable = ['titre', 'auteur', 'category_id', 'vues'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function exemplaires() {
        return $this->hasMany(Exemplaire::class);
    }
}
