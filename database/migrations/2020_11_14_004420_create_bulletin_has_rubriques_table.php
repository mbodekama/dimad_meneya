<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulletinHasRubriquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulletin_has_rubriques', function (Blueprint $table) {
            $table->id();
            $table->integer('montant');
            $table->unsignedBigInteger('bulletin_id');
            $table->foreign('bulletin_id')->references('id')->on('bulletins')
                                            ->onDelete('cascade');
            $table->unsignedBigInteger('rubrique_id');
            $table->foreign('rubrique_id')->references('id')->on('rubriques')
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
        Schema::dropIfExists('bulletin_has_rubriques');
    }
}
