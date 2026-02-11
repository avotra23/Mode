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
        Schema::create('options', function (Blueprint $table) {
           $table->id();
            $table->string('type'); // 'tissu', 'couleur', 'taille'
            $table->string('valeur'); // 'Soie', 'Rouge', 'XL'
            $table->decimal('surcout', 8, 2)->default(0); // Si un tissu coûte plus cher
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
