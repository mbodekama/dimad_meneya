<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsHasVentePrincipalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits_has_vente_principales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produits_id');
            $table->foreign('produits_id')->references('id')->on('produits')
                                            ->onDelete('cascade');            

            $table->unsignedBigInteger('vente_principales_id');
            $table->foreign('vente_principales_id')->references('id')
                            ->on('vente_principales')->onDelete('cascade');
            $table->integer('prixvente')->comment('Le prix auquel a été vendu le produits');
            $table->integer('qte');
            $table->integer('tva')->comment('Le pourcentage de la tva, une addition sur le prix de vente');
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
        Schema::dropIfExists('produits_has_vente_principales');
    }
}
