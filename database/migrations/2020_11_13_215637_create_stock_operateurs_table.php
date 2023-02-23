<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOperateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_operateurs', function (Blueprint $table) {
            $table->id();
            $table->integer('montant');
            $table->unsignedBigInteger('operateurs_id');
            $table->foreign('operateurs_id')->references('id')->on('operateurs')
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
        Schema::dropIfExists('stock_operateurs');
    }
}
