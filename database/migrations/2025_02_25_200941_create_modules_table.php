<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique(); // Nom du module
            $table->string('description')->nullable();
            $table->string('type'); // Ex: température, vitesse, etc.
            $table->string('unite'); // Unité de mesure (°C, m/s, %, etc.)
            $table->string('emplacement');
            $table->string('geolocalisation')->nullable();
            $table->dateTime('date_ajout')->default(now());
            $table->boolean('en_panne')->default(false); // Indique si le module est en panne
            $table->dateTime('date_reprise')->default(now()); // Indique la derniere fois que le module a changé d'état
            $table->dateTime('date_panne')->nullable(); // Indique la derniere fois que le module a changé d'état
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
