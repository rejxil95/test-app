<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();             // Auto-incrementing ID
        $table->string('name');   // Product name (string)
        $table->decimal('price', 8, 2);  // Price, decimal with 2 decimals
        $table->integer('stock');         // Stock quantity (integer)
        $table->text('description')->nullable();  // Description, nullable
        $table->timestamps();      // Created_at and updated_at timestamps
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
