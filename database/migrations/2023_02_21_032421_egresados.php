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
      
        Schema::create('egresados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('año_egresado');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('identidad')->unique()->nullable();
            $table->integer('nro_expediente')->nullable();
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
        Schema::dropIfExists('egresados');   
    }
};
