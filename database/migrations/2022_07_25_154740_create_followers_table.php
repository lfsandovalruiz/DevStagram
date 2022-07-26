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
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            // aquí el nombre "user_id" le indica a Laravel que se está haciendo referencia a la tabla users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // "follower_id" tambien hace referencia a users, pero el nombre no dice eso, por lo que lo indicamos en "constrained"
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('followers');
    }
};
