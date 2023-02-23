<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArrivageHasProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrivage_has_produits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qteproduits')->comment('Quantité du produits pris dans l\'arrivage\n');
            $table->bigInteger('coutachat')->comment('le coût d\'achat de la relation arrivage_has_produits définit le prix d\'achat actuel du produit et met à jour le prix d\'achat du produit dans la table produit\n\n');
            $table->bigInteger('prixvente')->comment('le prix de vente de la relation arrivage_has_produits définit le prix de vente actuel du produit et met à jour le prix de vente  du produit dans la table produit\n\n');
            $table->unsignedBigInteger('arrivage_id');
            $table->foreign('arrivage_id')->references('id')->on('arrivages')
                                            ->onDelete('cascade');
            $table->unsignedBigInteger('produits_id');
            $table->foreign('produits_id')->references('id')->on('produits')
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
        Schema::dropIfExists('arrivage_has_produits');
    }
}
