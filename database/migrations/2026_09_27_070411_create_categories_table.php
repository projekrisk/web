<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        DB::table('categories')->insert([
            ['name' => 'Enterprise', 'slug' => 'enterprise', 'created_at' => now()],
            ['name' => 'Retail', 'slug' => 'retail', 'created_at' => now()],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'created_at' => now()],
            ['name' => 'Edukasi', 'slug' => 'edukasi', 'created_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};