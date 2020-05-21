<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('jour');
            $table->integer('semaine');
            $table->integer('seance');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('etudiant_id');
            $table->timestamps();
            $table->foreign('semester_id')->references('id')->on('semestres');
            $table->foreign('etudiant_id')->references('id')->on('etudiants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absences');
    }
}
