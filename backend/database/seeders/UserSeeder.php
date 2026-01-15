<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin account
        User::create([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'email' => 'admin@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);

        // Test users
        $users = [
            [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '1234567890',
                'password' => Hash::make('password'),
                'status' => 'active',
            ],
            [
                'firstname' => 'Jane',
                'lastname' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '2345678901',
                'password' => Hash::make('password'),
                'status' => 'active',
            ],
            [
                'firstname' => 'Michael',
                'lastname' => 'Johnson',
                'email' => 'michael.johnson@example.com',
                'phone' => '3456789012',
                'password' => Hash::make('password'),
                'status' => 'active',
            ],
            [
                'firstname' => 'Emily',
                'lastname' => 'Williams',
                'email' => 'emily.williams@example.com',
                'phone' => '4567890123',
                'password' => Hash::make('password'),
                'status' => 'inactive',
            ],
            [
                'firstname' => 'David',
                'lastname' => 'Brown',
                'email' => 'david.brown@example.com',
                'phone' => '5678901234',
                'password' => Hash::make('password'),
                'status' => 'active',
            ],
            [
                'firstname' => 'Sarah',
                'lastname' => 'Davis',
                'email' => 'sarah.davis@example.com',
                'phone' => '6789012345',
                'password' => Hash::make('password'),
                'status' => 'active',
            ],
            [
                'firstname' => 'Robert',
                'lastname' => 'Miller',
                'email' => 'robert.miller@example.com',
                'phone' => '7890123456',
                'password' => Hash::make('password'),
                'status' => 'inactive',
            ],
            [
                'firstname' => 'Lisa',
                'lastname' => 'Wilson',
                'email' => 'lisa.wilson@example.com',
                'phone' => '8901234567',
                'password' => Hash::make('password'),
                'status' => 'active',
            ],
            [
                'firstname' => 'James',
                'lastname' => 'Moore',
                'email' => 'james.moore@example.com',
                'phone' => '9012345678',
                'password' => Hash::make('password'),
                'status' => 'active',
            ],
            [
                'firstname' => 'Maria',
                'lastname' => 'Taylor',
                'email' => 'maria.taylor@example.com',
                'phone' => '0123456789',
                'password' => Hash::make('password'),
                'status' => 'inactive',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
