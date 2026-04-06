<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
       Schema::create('products', function (Blueprint $table) {
    $table->id('product_id');
    $table->string('name');
    $table->double('price');
    $table->text('description');
    $table->enum('status',['active','inactive']);

  
    $table->foreignId('category_id')
          ->constrained('categories', 'category_id')
          ->onDelete('cascade');

    $table->timestamps();
});

    }

   
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
