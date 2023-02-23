<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffresHasAccesOffresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offres_has_acces_offres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offres_id');
            $table->foreign('offres_id')->references('id')->on('offres')
                                            ->onDelete('cascade');
            $table->unsignedBigInteger('accesOffres_id');
            $table->foreign('accesOffres_id')->references('id')->on('acces_offres')
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
        Schema::dropIfExists('offres_has_acces_offres');
    }
}
