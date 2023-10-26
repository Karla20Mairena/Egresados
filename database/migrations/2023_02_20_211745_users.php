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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('name')->unique()->nullable();
            $table->string('correo')->unique()->nullable();
            $table->date('nacimiento');
            $table->string('username')->unique()->nullable();
            $table->string('password')->unique()->nullable();
            $table->string('identidad')->unique()->nullable();
            $table->string('telefono')->unique()->nullable();
            $table->boolean('estado')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users'); 
    }
};
