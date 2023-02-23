<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versements', function (Blueprint $table) {
            $table->id();
            $table->string('versMat');
            $table->string('versStatu')
                    ->comment('soldé => 1 , non solde => 0');
            $table->string('versMnt');
            $table->string('dateDebut')->comment('La date de début de l\'intervalle de temps concerné par le versement');
            $table->string('dateFin')->comment('La date de début de l\'intervalle de temps concerné par le versement');
            $table->unsignedBigInteger('succursale_id');
            $table->foreign('succursale_id')->references('id')->on('succursales');
            $table->string('versDate')->comment('date de génération du versement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versements');
    }
}
