<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_recipe', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('product_id');
            $table->string('quantity');
            $table->timestamps();

            $table->foreign('recipe_id',)
                ->references('id')->on('recipes')
                ->onDelete('cascade');

            $table->foreign('product_id', 'fk_product_recipe')
                ->references('id')->on('products')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_recipe');
    }
};
