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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('meta_description', 160)->nullable(); 
            $table->longText('description');
            $table->decimal('price', 12, 2);
            $table->decimal('strike_price', 12, 2)->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->enum('status', ['active', 'draft'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
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