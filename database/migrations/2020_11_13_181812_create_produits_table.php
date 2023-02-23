<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('produitMat')->comment('code de l\'article');
            $table->string('produitLibele');
            $table->string('image')->default('assets/img/illustrations/falcon.png');
            $table->integer('seuilAlert')->default(10);
            $table->integer('produitPrix')->comment('Prix de vente du produit');
            $table->integer('produitPrixFour')->comment('Cout d\' achat du produit');
            $table->text('description')->nullable();
            $table->string('unite_mesure')->nullable();
            $table->integer('tva')->default(0);
            $table->integer('autre_charge')->default(0);
            $table->unsignedBigInteger('categorie_id');
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('produits');
    }
}
