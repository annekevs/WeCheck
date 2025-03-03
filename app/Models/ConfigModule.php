<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'seuil_min',
        'seuil_max',
        'frequence_mesure',
    ];

    // Relation avec le module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
