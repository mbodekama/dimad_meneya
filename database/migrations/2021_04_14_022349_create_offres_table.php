<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->string('libele')->comment('Nom de loffre de souscription');
            $table->string('prixInscription')->comment('Montant payer a l\'inscription ( contient le cout de l\'abonnement 01 mois de l\'offre + frais de deploiement)nt');
            $table->string('Coutabonnement')->comment('cout de l\'abonnement');
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
        Schema::dropIfExists('offres');
    }
}
