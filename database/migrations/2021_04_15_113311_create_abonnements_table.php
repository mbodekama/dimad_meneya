<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonnementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->string('dateDebut')->comment('date de debut d abonnement');
            $table->string('dateFin')->comment('date de fin d abonnement');
            $table->string('statuPaiement')->comment('Statut du paiemlent pour l\'
                                                        abonnement en cours 
                                                         0 => pour non  payer 
                                                         1 => Payement valider');
            $table->unsignedBigInteger('offres_id');
            $table->foreign('offres_id')->references('id')->on('offres')
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
        Schema::dropIfExists('abonnements');
    }
}
