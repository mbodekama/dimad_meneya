<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovisionnementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvisionnements', function (Blueprint $table) {
            $table->id();
            $table->string('approvisionMat')->default('0');
            $table->string('approvisionStatut')->default('0');
            $table->string('approvisionMontant')->default('0');
            $table->string('approvisionTotal')->default('0');
            $table->string('dateApro')->default('0');
            $table->string('charge')->nullable();
            $table->string('description_charge')->nullable();
            $table->unsignedBigInteger('succursale_id');
            $table->foreign('succursale_id')->references('id')->on('succursales');
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
        Schema::dropIfExists('approvisionnements');
    }
}
