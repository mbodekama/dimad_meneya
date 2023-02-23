<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactureachatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factureachats', function (Blueprint $table) {
            $table->id()->comment('Ici on enregistre le devis soldé ou la facture proformat soldée du client.\nLa quantité du stock est déduite à partir de la quantité de la facture achat. ');
            $table->string('ref');
            $table->string('datefacture')->comment('La date d\'édition de la facture',);
            $table->string('dateecheance')->comment('La date d\'édition de la facture',);
            $table->integer('totalttc');
            $table->integer('totalhtc');
            $table->string('paiementmode');
            $table->integer('session')->comment('La session de celui qui a enregistré la factureachat\n');
            $table->unsignedBigInteger('ventes_succursales_id');
            $table->foreign('ventes_succursales_id')->references('id')->on('ventes_succursales')
                                            ->onDelete('cascade');
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
        Schema::dropIfExists('factureachats');
    }
}
