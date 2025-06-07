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
        Schema::create('action_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // create, update, delete
            $table->string('table'); // e.g., products
            $table->unsignedBigInteger('table_id'); // ID of affected record
            $table->timestamp('date_created')->useCurrent(); // timestamp
            $table->unsignedBigInteger('created_by')->nullable(); // user ID if available
            $table->timestamps(); // includes created_at, updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_logs');
    }
};
