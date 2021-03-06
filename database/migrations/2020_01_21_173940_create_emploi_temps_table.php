<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploiTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emploi_temps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('temp');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('filiere_id');
            
            $table->softDeletes();
            $table->timestamps();


            
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
        Schema::dropIfExists('emploi_temps');
    }
}
