<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentesSuccursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventes_succursales', function (Blueprint $table) {
            $table->id();
            $table->string('NumVente');
            $table->integer('qte')->nullable();
            $table->string('dateV')->nullable();
            $table->integer('cout_achat_total')->nullable();
            $table->integer('prix_vente_total')->nullable();
            $table->integer('mg_benef_brute')->nullable();
            $table->integer('mg_benef_rel')->nullable();
            $table->string('charge')->nullable();
            $table->string('description_charge')->nullable();
            $table->string('typevente')->comment('TYPE DE VENTE:\n- Dévis (Par défaut)\n- Facture proformat\n ');
            $table->unsignedBigInteger('succursale_id');
            $table->foreign('succursale_id')->references('id')->on('succursales')
                                            ->onDelete('cascade');
            $table->unsignedBigInteger('clients_id');
            $table->foreign('clients_id')->references('id')->on('clients')
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
        Schema::dropIfExists('ventes_succursales');
    }
}
