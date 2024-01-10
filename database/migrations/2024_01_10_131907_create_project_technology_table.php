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
        // 1. Creo la tabella 'project_technology'
        Schema::create('project_technology', function (Blueprint $table) {
            $table->id(); // 2. Creo una colonna 'id' come chiave primaria auto-incrementante
            // 3. Creo due colonne 'project_id' e 'technology_id' come chiavi esterne  per collegarsi rispettivamente alle tabelle 'projects' e 'technologies'
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('technology_id');
            $table->timestamps(); // 4. Creo colonne 'created_at' e 'updated_at' per tenere traccia delle timestamp
            // 5. Aggiungo vincoli di chiave esterna per garantire integrità referenziale con le tabelle 'projects' e 'technologies'. In caso di eliminazione di un
            //    record nelle tabelle principali, i record associati in questa tabella saranno eliminati (onDelete('cascade')).
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('technology_id')->references('id')->on('technologies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_technology');
    }
};
