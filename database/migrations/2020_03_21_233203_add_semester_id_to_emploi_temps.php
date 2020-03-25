<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSemesterIdToEmploiTemps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emploi_temps', function (Blueprint $table) {

           $table->unsignedBigInteger('semester_id')->nullable();
           $table->foreign('semester_id')->references('id')->on('semestres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emploi_temps', function (Blueprint $table) {
            $table->dropColumn('semester_id');
        });
    }
}
