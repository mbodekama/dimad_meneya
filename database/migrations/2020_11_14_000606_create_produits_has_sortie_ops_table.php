<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsHasSortieOpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits_has_sortie_ops', function (Blueprint $table) {
            $table->id();
            $table->integer('qte');
            $table->integer('prixvente');
            $table->integer('tva')->nullable();
            $table->unsignedBigInteger('produits_id');
            $table->foreign('produits_id')->references('id')->on('produits')
                                            ->onDelete('cascade');
            $table->unsignedBigInteger('sortie_ops_id');
            $table->foreign('sortie_ops_id')->references('id')->on('sortie_ops')
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
        Schema::dropIfExists('produits_has_sortie_ops');
    }
}
