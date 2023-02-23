<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrincipFactuAchatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('princip_factu_achats', function (Blueprint $table) {
            $table->id()->comment('Ici on enregistre le devis soldé ou la facture proformat soldée du client.\nLa quantité du stock est déduite à partir de la quantité de la facture achat. ');
            $table->string('ref')->comment('la référence de la facture achat\ncode de référence:\nFA_ANNEE_MOIS_RANG\n');
            $table->string('datefacture');
            $table->string('dateecheance');
            $table->integer('totalttc');
            $table->integer('totalhtc');
            $table->string('paiementmode');
            $table->string('session');
            $table->unsignedBigInteger('vente_principales_id');
            $table->foreign('vente_principales_id')->references('id')
            ->on('vente_principales')->onDelete('cascade');
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
        Schema::dropIfExists('princip_factu_achats');
    }
}
