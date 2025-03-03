<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'type',
        'unite',
        'emplacement',
        'geolocalisation',
        'en_panne',
        'date_ajout',
        'date_reprise',
        'date_panne'
    ];

    function getTimeElapsed($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);

        // Use current time if no end date is provided
        $end = $endDate ? Carbon::parse($endDate) : Carbon::now();

        // Calculate the difference
        $diff = $start->diff($end);

        // If there is no year, month, or day, just return hours, minutes, and seconds in hh:mm:ss format
        if ($diff->y == 0 && $diff->m == 0 && $diff->d == 0) {
            return $diff->h . 'h ' . str_pad($diff->i, 2, '0', STR_PAD_LEFT) . 'm ' . str_pad($diff->s, 2, '0', STR_PAD_LEFT) . 's';
        }

        // Format the result with years, months, days, hours, minutes, seconds
        $result = '';
        if ($diff->y > 0) {
            $result .= $diff->y . ' years ';
        }
        if ($diff->m > 0) {
            $result .= $diff->m . ' months ';
        }
        if ($diff->d > 0) {
            $result .= $diff->d . ' days ';
        }
        if ($diff->h > 0 || $diff->i > 0 || $diff->s > 0) {
            $result .= sprintf('%02d:%02d:%02d', $diff->h, $diff->i, $diff->s);
        }

        return trim($result);
    }

    // Méthode pour récupérer la durée de fonctionnement (en heures, minutes)
    public function getDuree()
    {
        if (!$this->date_reprise || !$this->date_panne) {
            return 'Non disponible';
        }

        // Calculer la différence en heures et minutes entre la date actuelle et la dernière vérification
        $derniereReprise = Carbon::parse($this->date_reprise);
        // $duree = $derniereReprise->diffForHumans(derniereReprise(), ['parts' => 3]);  // Exemple : '1 hour ago'
        $dernierePanne = Carbon::parse($this->date_panne);

        $duree = $this->getTimeElapsed($dernierePanne, $derniereReprise);

        return $duree;
    }

    // Méthode pour récupérer le nombre de données envoyées (nombre de mesures)
    public function getTotalDonnees()
    {
        return $this->donnees()->count();  // Compter le nombre de mesures associées au module
    }

    // Relation avec les donnees
    public function donnees()
    {
        return $this->hasMany(Donnee::class);
    }

    // Relation avec l'historique d'état
    public function etats()
    {
        return $this->hasMany(EtatModule::class);
    }

    // Relation avec la configuration du module
    public function configModule()
    {
        return $this->hasOne(ConfigModule::class);
    }
}
