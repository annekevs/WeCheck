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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();  // La colonne 'id' est de type UUID et sera la clé primaire
            $table->string('type'); // Type de la notification
            $table->json('data'); // Données associées à la notification (généralement au format JSON)
            $table->timestamp('read_at')->nullable(); // Date de lecture
            $table->morphs('notifiable'); // Ajoute les colonnes notifiable_id et notifiable_type pour polymorphisme
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
