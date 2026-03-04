<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('riankarlosweber13@gmail.com');
        $password = env('102030405060');

        if (!$email || !$password) {
            return;
        }

        if (User::where('email', $email)->exists()) {
            return;
        }

        User::create([
            'name'     => env('ADMIN_NAME', 'Admin'),
            'email'    => $email,
            'password' => Hash::make($password),
        ]);
    }
}
