<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->string('creditEcheance');
            $table->string('creditMontant');
            $table->string('creditStatut');
            $table->string('creditDate');
            $table->string('description');
            $table->string('vente_id');
            $table->unsignedBigInteger('sucId');
            $table->foreign('sucId')->references('id')
                            ->on('succursales')
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
        Schema::dropIfExists('credits');
    }
}
