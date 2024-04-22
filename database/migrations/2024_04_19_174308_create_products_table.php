<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->double('id')->primary(); // Cambiar a double y establecerlo como clave primaria
            $table->unsignedBigInteger('subcategory_id'); 
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade'); 
            $table->integer('limit')  -> nullable();
            $table->string('packaging') -> nullable();
            $table->string('thumbnail')  -> nullable();
            $table->string('display_name')  -> nullable();
            $table->decimal('unit_price', 8, 2)->nullable(); // Agregar el campo unit_price
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
