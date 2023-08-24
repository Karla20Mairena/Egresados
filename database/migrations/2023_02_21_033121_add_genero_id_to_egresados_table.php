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
        Schema::table('egresados', function (Blueprint $table) {
            $table->unsignedInteger('gene_id');

            $table->foreign('gene_id')->references('id')->on('generos')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('egresados', function (Blueprint $table) {
            //
        });
    }
};
