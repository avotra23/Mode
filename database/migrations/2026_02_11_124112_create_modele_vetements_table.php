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
        Schema::create('modele_vetements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained()->onDelete('cascade');
            $table->string('nom'); // Ex: "Robe Bazin Royale"
            $table->text('description')->nullable();
            $table->decimal('prix_base', 10, 2); // Pour le calcul automatique
            $table->json('images')->nullable(); // Stockage des chemins d'images (galerie)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modele_vetements');
    }
};
