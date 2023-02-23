<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsHasVentesSuccursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits_has_ventes_succursales', function (Blueprint $table) {
            $table->id();
            $table->integer('prixvente');
            $table->integer('coutAchat')->default(0)->comment('Le prix auquel la succursal a obtenu le produit');
            $table->integer('qte');
            $table->integer('tva')->comment('Le pourcentage de la tva, une addition sur le prix de vente');
            $table->unsignedBigInteger('produits_id');
            $table->foreign('produits_id')->references('id')->on('produits')
                                            ->onDelete('cascade');
            $table->unsignedBigInteger('ventes_succursales_id');
            $table->foreign('ventes_succursales_id')->references('id')->on('ventes_succursales')->onDelete('cascade');
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
        Schema::dropIfExists('produits_has_ventes_succursales');
    }
}
