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
        Schema::create('annonces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_prevue');
            $table->date('date_auralieu');
            $table->string('salle');
            $table->unsignedBigInteger('typeannonce_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('matiere_id');
            $table->unsignedBigInteger('prof_id');
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
        Schema::dropIfExists('annonces');
    }
}
