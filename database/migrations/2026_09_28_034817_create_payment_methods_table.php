<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name'); 
            $table->string('account_number'); 
            $table->string('account_owner'); 
            $table->enum('status', ['active', 'inactive'])->default('active'); 
            $table->timestamps();
        });

        DB::table('payment_methods')->insert([
            [
                'bank_name' => 'BCA', 
                'account_number' => '1234-5678-90', 
                'account_owner' => 'Projekrisk Technology', 
                'status' => 'active', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'bank_name' => 'Bank Mandiri', 
                'account_number' => '098-765-4321', 
                'account_owner' => 'Projekrisk Technology', 
                'status' => 'active', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};