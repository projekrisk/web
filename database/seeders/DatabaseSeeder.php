<?php
namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@projekrisk.com'],
            [
                'name' => 'Admin Master',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
        
        User::updateOrCreate(
            ['email' => 'member@projekrisk.com'],
            [
                'name' => 'Member Tester',
                'password' => Hash::make('password123'),
                'role' => 'member',
            ]
        );
    }
}