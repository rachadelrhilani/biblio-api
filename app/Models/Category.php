<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['livre_id', 'etat_physique', 'est_disponible'];

    public function livre() {
        return $this->belongsTo(Livre::class);
    }
}
