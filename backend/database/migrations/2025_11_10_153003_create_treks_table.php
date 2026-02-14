<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('treks', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('regNumber')->unique();
            $table->integer('totalRating')->default(0); 
            $table->integer('countRating')->default(0); 
            $table->decimal('rating',5,2)->default(0);  
            $table->foreignId('municipality_id')->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->enum('status', ['y', 'n'])->default('y');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treks');
    }
};
