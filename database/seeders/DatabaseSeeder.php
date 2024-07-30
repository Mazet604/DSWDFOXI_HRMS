<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed emp_acc table with first entry
        DB::table('emp_acc')->insert([
            'empid' => '11-0070',
            'empuser' => 'jgmatugas',
            'emppass' => Hash::make('matugas@2023'),
            'empmail' => 'jgmatugas117@gmail.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed emp_acc table with second entry
        DB::table('emp_acc')->insert([
            'empid' => '11-0071',
            'empuser' => 'tdadlawan',
            'emppass' => Hash::make('adlawan@2023'),
            'empmail' => 'adlawan117@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}