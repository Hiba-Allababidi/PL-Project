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
            $table->id();
            $table->bigInteger('User_ID');
            $table->string('Name');
            $table->string('Image_Name');
            $table->string('Photo_Path');
            $table->string('Category');
            $table->double('Quantity');
            $table->double('Price');
            $table->dateTime('Expiry_Date');
            $table->string('Phone_Number');
            //$table->integer('views');
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
