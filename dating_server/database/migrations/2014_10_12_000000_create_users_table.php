<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('gender');
            $table->string('interested_in');
            $table->date('DOB')->nullable();
            $table->string('Latitude');
            $table->string('Longitude');
            $table->string('password');
            $table->string('profile_img')->nullable();
            $table->string('bio')->nullable();
            $table->boolean('visible')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('users');
    }
};
