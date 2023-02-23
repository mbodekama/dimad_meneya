<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuccursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('succursales', function (Blueprint $table) {
            $table->id();
            $table->string('succursaleMat')->nullable();
            $table->string('succursaleLibelle')->nullable();
            $table->string('succursalLieu')->nullable();
            $table->string('succursalContact')->nullable();
            $table->string('datesucu')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('succursales');
    }
}
