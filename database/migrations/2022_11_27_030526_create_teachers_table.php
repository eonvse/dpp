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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic')->nullable();
            $table->unsignedBigInteger('idPositions')->default(0);
            $table->unsignedBigInteger('idInstitutions')->default(0);
            $table->unsignedBigInteger('idUser')->default(0);
            $table->unsignedBigInteger('idAutor');
            $table->unsignedBigInteger('idUpdater');
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
        Schema::dropIfExists('teachers');
    }
};
