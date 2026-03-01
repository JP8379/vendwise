<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
       User::updateOrCreate(
    ['email' => 'admin@vendwise.com'],
    [
        'name' => 'Admin',
        'business_name' => 'VendWise HQ',
        'phone_number' => '0127726434',
        'password' => Hash::make('Admin12345.'),
        'role' => 'admin',
    ]
);
    }
}