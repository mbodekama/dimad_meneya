<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockSuccursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_succursales', function (Blueprint $table) {
            $table->id();
            $table->string('stock_Qte');
            $table->unsignedBigInteger('produits_id');
            $table->foreign('produits_id')->references('id')->on('produits')
                                            ->onDelete('cascade');
            $table->unsignedBigInteger('succursale_id');
            $table->integer('sucCoutAchat')->nullable();
            $table->foreign('succursale_id')->references('id')->on('succursales')
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
        Schema::dropIfExists('stock_succursales');
    }
}
