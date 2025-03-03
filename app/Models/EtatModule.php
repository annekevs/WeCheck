<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtatModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'etat',
    ];

    // Relation avec le module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
