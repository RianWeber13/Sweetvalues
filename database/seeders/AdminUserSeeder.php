<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
        ['email' => 'admin@gmail.com'],
        [
            'name' => 'Admin SweetValues',
            'password' => Hash::make('1234'),
        ]
        );
    }
}