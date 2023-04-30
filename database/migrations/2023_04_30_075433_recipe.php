<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('preparation');
            $table->double('rating')->default(0);
            $table->double('calories')->default(0);
            $table->double('preparation_time')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipes');
    }
};
