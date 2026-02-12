<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            // On place user_id juste après l'id
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->string('image')->nullable();
            $table->string('saison')->nullable();
            $table->year('annee');
            $table->text('description')->nullable();
            $table->boolean('est_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Supprime simplement la table. C'est suffisant et ça évite l'erreur 1146.
        Schema::dropIfExists('collections');
    }
};
