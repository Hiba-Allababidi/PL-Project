<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->bigInteger('user_id');
            $table->string('name');
            $table->string('photo_name');
            $table->string('photo_path');
            $table->string('category');
            $table->double('quantity');
            $table->double('price');
            $table->date('expiry_date')->always();
            $table->string('phone_number');
            $table->integer('discount2');
            $table->integer('discount3');
            $table->integer('views');
            $table->integer('likes');
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
        Schema::dropIfExists('products');
    }
}
