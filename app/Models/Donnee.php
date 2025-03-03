<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donnee extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'valeur',
        'created_at',
    ];

    // Relation avec le module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
