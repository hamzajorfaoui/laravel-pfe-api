<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('profs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone');
            $table->string('fullname');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('departement_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('departement_id')->references('id')->on('departements');
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
        Schema::dropIfExists('profs');
    }
}
