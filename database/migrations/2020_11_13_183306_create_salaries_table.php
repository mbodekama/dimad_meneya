<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('naissance');
            $table->string('civilité')->comment('Madame  ou Monsieur');
            $table->string('fonction');
            $table->string('ville');
            $table->string('numero');
            $table->string('email');
            $table->string('photo');
            $table->string('embauche')->comment('date d\'embauche');
            $table->string('salaire');

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
        Schema::dropIfExists('salaries');
    }
}
