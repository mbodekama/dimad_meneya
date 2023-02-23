<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcheancehistoriquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('echeancehistoriques', function (Blueprint $table) {
            $table->id();
            $table->string('nomAgent');
            $table->string('montantPaye');
            $table->string('datePaiement');
            $table->string('banque');
            $table->string('typepaiement');
            $table->unsignedBigInteger('echeance_id');
            $table->foreign('echeance_id')->references('id')->on('echeances')
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
        Schema::dropIfExists('echeancehistoriques');
    }
}
