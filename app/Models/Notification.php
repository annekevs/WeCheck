<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'notifiable_id',
        'notifiable_type',
        'type',
        'data',
    ];

    /**
     * Indiquer si l'ID doit être un UUID.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Le type de clé primaire de la table.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Bootstrap les paramètres par défaut.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Générer un UUID pour l'ID avant de créer la notification
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
