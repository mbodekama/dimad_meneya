<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentePrincipalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vente_principales', function (Blueprint $table) {
            $table->id();
            $table->string('NumVente');
            $table->integer('qte')->default(0);
            $table->string('dateV');
            $table->string('cout_achat_total')->default(0);
            $table->string('prix_vente_total')->default();
            $table->integer('mg_benef_brute')->default(0);
            $table->integer('mg_benef_rel')->default(0);
            $table->integer('charge')->default(0);
            $table->string('description_charge')->default(0);
            $table->string('typevente')->comment('0 => facture proformat / 1 => Vente')->default(0);
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
        Schema::dropIfExists('vente_principales');
    }
}
