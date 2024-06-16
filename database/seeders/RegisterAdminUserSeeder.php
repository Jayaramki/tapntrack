<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'user_type' => 1,
            'franchise_id' => 0,
            'username' => 'admin1',
            'password' => Hash::make('123456'),
            'first_name' => 'Admin',
            'last_name' => '1',
            'email' => 'testadmin1@felapp.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
            'is_active' => true,
        ]);

        $admin->assignRole('admin');
    }
}
