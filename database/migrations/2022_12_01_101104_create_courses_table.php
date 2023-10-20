<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id()->unique();
            $table->unsignedBigInteger('idType')->default(0);
            $table->date('dateDoc')->nullable();
            $table->integer('hours')->default(0);
            $table->text('fullName');
            $table->text('progName');
            $table->unsignedBigInteger('idDirections')->default(0);
            $table->boolean('isFederal')->default(0);
            $table->unsignedBigInteger('idAutor');
            $table->unsignedBigInteger('idUpdater');
            $table->timestamps();
        });


        Schema::table('courses', function (Blueprint $table) {

            $table->unsignedBigInteger('idTeachers')->after('id');
            $table->foreign('idTeachers')->references('id')->on('teachers');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};

