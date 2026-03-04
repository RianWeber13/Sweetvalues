<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'riankarlosweber13@gmail.com';

        if (User::where('email', $email)->exists()) {
            return;
        }

        User::create([
            'name'              => 'Admin',
            'email'             => $email,
            'password'          => Hash::make('102030405060'),
            'email_verified_at' => now(),
        ]);
    }
}
