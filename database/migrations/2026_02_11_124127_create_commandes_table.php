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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Le client
            $table->foreignId('styliste_id')->nullable()->constrained('users'); // Le créateur assigné
            $table->foreignId('modele_vetement_id')->constrained();

            // Détails de personnalisation enregistrés au moment de l'achat
            $table->string('taille_choisie');
            $table->string('tissu_choisi');
            $table->string('couleur_choisie');
            $table->text('commentaires_personnalisation')->nullable();

            //En cas de non validation
            $table->string('reponse');


            $table->decimal('prix_total', 10, 2);
            $table->string('statut')->default('en_attente'); // en_attente, en_confection, termine, livre
            $table->date('date_prevue')->nullable();

            $table->string('telephone_paiement'); 
            $table->string('operateur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
