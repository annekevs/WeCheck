# IoT Monitoring Application - WeCheck

## Description

WeCheck est une application web pour surveiller et suivre en temps réel l’état des modules IoT. Elle permet de visualiser l’historique des mesures, de détecter les pannes, d’afficher des notifications en temps réel et d’analyser les données collectées.

## Technologies utilisées

- **Framework** : Laravel
- **Base de données** : MySQL (nommée `we_check`)
- **Notifications en temps réel** : Pusher
- **Frontend** : HTML / CSS / JavaScript / Bootstrap

## Installation

### Prérequis

- PHP 8+
- Composer
- MySQL
- Node.js & NPM

### Étapes d’installation

1. **Cloner le projet** :

   ```sh
   git clone https://github.com/votre-repo/wecheck.git
   cd wecheck
   ```

2. **Installer les dépendances PHP** :

   ```sh
   composer install
   ```

3. **Configurer l’environnement** :
   Copier le fichier `.env.example` en `.env` :

   ```sh
   cp .env.example .env
   ```

   Modifier les valeurs suivantes dans `.env` :

   ```env
   DB_DATABASE=we_check
   DB_USERNAME=root
   DB_PASSWORD=votre_mot_de_passe
   PUSHER_APP_ID=votre_app_id
   PUSHER_APP_KEY=votre_app_key
   PUSHER_APP_SECRET=votre_app_secret
   PUSHER_APP_CLUSTER=eu
   ```

4. **Générer la clé d’application** :

   ```sh
   php artisan key:generate
   ```

5. **Exécuter les migrations et seeders** :

   ```sh
   php artisan migrate --seed
   ```

6. **Démarrer le serveur local** :
   ```sh
   php artisan serve
   ```

## Fonctionnalités

- Gestion des modules IoT (température, vitesse du vent, humidité, pression, etc.)
- Génération automatique de données et détection des pannes
- Stockage des mesures et de l’historique des modules
- Notifications en temps réel via Pusher
- Interface graphique pour la visualisation des données

## Base de données

### Tables principales

- **modules** : Contient les informations sur les modules (nom, type, emplacement, état de panne...)
- **etat_modules** : Stocke l’historique des états des modules
- **notifications** : Gère les notifications envoyées aux utilisateurs
- **donnees** : Contient les données de mesure des modules

### Seeder : `ModuleSeeder`

Lors de l’installation, la base de données est peuplée avec quelques modules de test :

```php
class ModuleSeeder extends Seeder {
    public function run() {
        DB::table('modules')->insert([
            [
                'nom' => 'Température',
                'description' => 'Module pour mesurer la température',
                'type' => 'Température',
                'unite' => '°C',
                'emplacement' => '123 Rue de la Technologie, Paris, Salle serveurs',
                'geolocalisation' => '48.8566, 2.3522',
                'en_panne' => false,
                'date_ajout' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nom' => 'Vitesse du vent',
                'description' => 'Module pour mesurer la vitesse du vent',
                'type' => 'Vitesse',
                'unite' => 'm/s',
                'emplacement' => '45 Avenue de l’Innovation, Paris, Toit de l’immeuble',
                'geolocalisation' => '48.8566, 2.3522',
                'en_panne' => false,
                'date_ajout' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nom' => 'Humidité',
                'description' => 'Module pour mesurer l’humidité de l’air',
                'type' => 'Humidité',
                'unite' => '%',
                'emplacement' => '78 Boulevard des Sciences, Paris, Bureau principal',
                'geolocalisation' => '48.8566, 2.3522',
                'en_panne' => false,
                'date_ajout' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nom' => 'Pression atmosphérique',
                'description' => 'Module pour mesurer la pression atmosphérique',
                'type' => 'Pression',
                'unite' => 'hPa',
                'emplacement' => '56 Rue de la Recherche, Paris, Salle des machines',
                'geolocalisation' => '48.8566, 2.3522',
                'en_panne' => true,
                'date_ajout' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
```

## Exécution de la génération automatique des données

La commande `php artisan generate:donnees` permet de générer des données en continu pour les modules actifs.  
Elle accepte deux paramètres facultatifs :

- `frequence` : définit l’intervalle de génération des données (en secondes). Par défaut : 5 secondes.
- `probabilite` : définit la probabilité qu’un module tombe en panne (en pourcentage). Par défaut : 25%.

Exemple d’utilisation avec des valeurs personnalisées : Ici, les données seront générées toutes les 10 secondes avec une probabilité de panne de 30 %.

```sh
php artisan generate:donnees 10 30
```

```sh
php artisan generate:donnees
```

## Notifications en temps réel

Les notifications sont envoyées via Pusher lorsqu’un module tombe en panne ou redevient actif. Les utilisateurs sont informés instantanément via l’interface web.

## API

L’application expose certaines routes API pour interagir avec les modules et récupérer les données en temps réel.

## Demo

You can watch the video [here](https://drive.google.com/file/d/1NWeJDCp5TEMxMwAI-uiWL4YsmFAE7cQP/view)

## Auteur

- **Nom** : Anne Kevina Nguen
- **Email** : annekevinanguen091@example.com
- **GitHub** : [Mon Profil GitHub](https://github.com/annekevs)

---
