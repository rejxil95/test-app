<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This is an anonymous migration class for creating the 'categories' table
return new class extends Migration
{
    /**
     * Run the migrations.
     * This method defines the structure of the 'categories' table.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key: 'id'
            $table->timestamps(); // 'created_at' and 'updated_at' timestamp columns

            // Foreign key to support nested categories (a category can belong to another category)
            // This allows hierarchical categories like "Electronics > Laptops"
            $table->foreignId('category_id')
                  ->nullable() // Allows this field to be null for top-level categories
                  ->constrained('categories') // References the 'id' on the same table
                  ->onDelete('set null'); // If the parent category is deleted, set this to null
        });
    }

    /**
     * Reverse the migrations.
     * This method will drop the 'categories' table when rolling back the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
