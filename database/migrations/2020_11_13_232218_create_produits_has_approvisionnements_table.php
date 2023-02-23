<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsHasApprovisionnementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits_has_approvisionnements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qteproduits');
            $table->bigInteger('coutachat');
            $table->bigInteger('prixvente');
            $table->unsignedBigInteger('produits_id');
            $table->foreign('produits_id')->references('id')->on('produits')
                                            ->onDelete('cascade');
            $table->unsignedBigInteger('approvisionnement_id');
            $table->foreign('approvisionnement_id')->references('id')
            ->on('approvisionnements')->onDelete('cascade');
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
        Schema::dropIfExists('produits_has_approvisionnements');
    }
}
