<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProspectHasOffresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospect_has_offres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prospect_id');
            $table->foreign('prospect_id')->references('id')->on('prospects')
                                            ->onDelete('cascade');
            $table->unsignedBigInteger('offres_id');
            $table->foreign('offres_id')->references('id')->on('offres')
                                            ->onDelete('cascade');
            $table->string('datetest')->comment('La date de teste de la solution\n');
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
        Schema::dropIfExists('prospect_has_offres');
    }
}
