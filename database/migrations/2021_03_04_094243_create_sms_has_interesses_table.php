<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsHasInteressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_has_interesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sms_id');
            $table->foreign('sms_id')->references('id')->on('sms')
                                            ->onDelete('cascade');
            $table->unsignedBigInteger('interesse_id');
            $table->foreign('interesse_id')->references('id')->on('interesse')
                                            ->onDelete('cascade');
            $table->integer('montant')->nullable();
            $table()->integer('qte')->nullable();
            $table()->boolean('etat')->nullable();
            $table()->boolean('statut')->nullable();
            $table()->string('code')->nullable();
            $table()->string('dateCmd')->nullable();
                                            
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
        Schema::dropIfExists('sms_has_interesses');
    }
}
