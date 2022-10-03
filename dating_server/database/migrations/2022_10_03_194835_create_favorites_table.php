<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('favorite', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("favorited_id")->constrained("users");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorite');
    }
};
