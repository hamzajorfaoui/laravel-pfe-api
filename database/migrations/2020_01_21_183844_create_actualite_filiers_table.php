<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActualiteFiliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actualite_filiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('actualite_id');
            $table->unsignedBigInteger('filiere_id');
            $table->timestamps();

            $table->foreign('actualite_id')->references('id')->on('actualites');
            $table->foreign('filiere_id')->references('id')->on('filieres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actualite_filiers');
    }
}
