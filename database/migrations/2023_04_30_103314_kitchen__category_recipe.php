<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kitchen__category_recipe', function (Blueprint $table) {
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('kitchen__category_id');
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('kitchen__category_id')->references('id')->on('kitchen__categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kitchen__category_recipe');
    }
};
