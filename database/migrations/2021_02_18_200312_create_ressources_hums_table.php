<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRessourcesHumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ressources_hums', function (Blueprint $table) {
            $table->id();
            $table->string('ressourcesMat')->nullable();
            $table->string('ressourcesHumMetier')->nullable();
            $table->string('ressourcesHumNom')->nullable();
            $table->string('ressourcesHEmba')->nullable();
            $table->string('ressourcesHContact')->nullable();
            $table->string('ressourcesHumLieu')->nullable();
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
        Schema::dropIfExists('ressources_hums');
    }
}
