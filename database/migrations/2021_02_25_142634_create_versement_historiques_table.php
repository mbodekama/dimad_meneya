->nullable()<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersementHistoriquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versement_historiques', function (Blueprint $table) {
            $table->id();
            $table->string('nomAgent')->nullable();
            $table->string('montantPaye')->nullable();
            $table->string('datePaiement')->nullable();
            $table->string('typepaiement')->nullable();
            $table->unsignedBigInteger('versement_id');
            $table->foreign('versement_id')->references('id')->on('versements')->onDelete('cascade');
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
        Schema::dropIfExists('versement_historiques');
    }
}
