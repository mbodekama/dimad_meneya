<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avances', function (Blueprint $table) {
            $table->id();
            $table->string('refAvance');
            $table->string('dateAvance');
            $table->string('montantAvance');
            $table->string('statusAvance')->comment('status de l\'avance soit :\nSolde => 0\nEn cours => 1\n');
            $table->unsignedBigInteger('salarie_id');
            $table->foreign('salarie_id')->references('id')->on('salaries')
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
        Schema::dropIfExists('avances');
    }
}
