<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtudiantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname');
            $table->string('cin');
            $table->string('cne');
            $table->unsignedBigInteger('filiere_id');
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('filiere_id')->references('id')->on('filieres');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
}
