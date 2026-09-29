<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('download_type', ['link', 'file'])->default('link')->after('status');
            $table->string('download_link')->nullable()->after('download_type');
            $table->string('download_file')->nullable()->after('download_link');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['download_type', 'download_link', 'download_file']);
        });
    }
};