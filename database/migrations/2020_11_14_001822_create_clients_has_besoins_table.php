<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsHasBesoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_has_besoins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clients_id');
            $table->foreign('clients_id')->references('id')->on('clients')
                                            ->onDelete('cascade');
            $table->unsignedBigInteger('besoins_id');
            $table->foreign('besoins_id')->references('id')->on('besoins')
                                            ->onDelete('cascade');
            $table->string('dateD')->comment('La date de demande\n');
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
        Schema::dropIfExists('clients_has_besoins');
    }
}
