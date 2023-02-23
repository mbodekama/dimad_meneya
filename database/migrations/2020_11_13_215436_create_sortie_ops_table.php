<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSortieOpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sortie_ops', function (Blueprint $table) {
            $table->id();
            $table->string('matSortie')->nullable();
            $table->string('libelleSortie')->nullable();
            $table->integer('montantS')->nullable();
            $table->integer('quantiteS')->nullable();
            $table->string('dateSortie')->nullable();
            $table->string('charges')->nullable();
            $table->string('chargesDesc')->nullable();
            $table->string('tva')->nullable();
            $table->unsignedBigInteger('operationsOperateurs_id');
            $table->foreign('operationsOperateurs_id')
            ->references('id')->on('operation_has_operateurs')->onDelete('cascade');
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
        Schema::dropIfExists('sortie_ops');
    }
}
