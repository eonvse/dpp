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
        Schema::table('teachers', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('idType')->default(0)->after('idInstitutions');
            $table->date('dateDoc')->nullable()->after('idType');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('idType', function (Blueprint $table) {
            //
            $table->dropColumn('idType');
            $table->dropColumn('dateDoc');
        });
    }
};
