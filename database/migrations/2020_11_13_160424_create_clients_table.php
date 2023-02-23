<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('statutClt')->comment('le statut du client défini s\'il est un prospect donc pas encore d\'achat et s\'il est un client donc a  dejà effectué un achat.\n\nstatut = 0 => prospect \nstaut = 1 =>  client\n\n');
             $table->string('nom');
             $table->string('contact');
             $table->string('lieu');
             $table->string('date');
             $table->string('mail')->default(0);
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
        Schema::dropIfExists('clients');
    }
}
