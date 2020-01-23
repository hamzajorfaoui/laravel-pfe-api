<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnoncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('annonces');
        Schema::create('annonces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_prevue');
            $table->date('date_auralieu');
            $table->string('salle');
            $table->unsignedBigInteger('typeannonce_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('matiere_id');
            $table->unsignedBigInteger('prof_id');
            $table->unsignedBigInteger('filiere_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('typeannonce_id')->references('id')->on('type_annonces');
            $table->foreign('prof_id')->references('id')->on('profs');
            $table->foreign('matiere_id')->references('id')->on('matieres');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('annonces');
    }
}
