<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 3 clients
        User::create([
            'lastName' => 'Client1',
            'firstName' => 'User',
            'username' => 'client1',
            'email' => 'client1@example.com',
            'password' => Hash::make('password'),
            'role' => 'client'
        ]);

        User::create([
            'lastName' => 'Client2',
            'firstName' => 'User',
            'username' => 'client2',
            'email' => 'client2@example.com',
            'password' => Hash::make('password'),
            'role' => 'client'
        ]);

        User::create([
            'lastName' => 'Client3',
            'firstName' => 'User',
            'username' => 'client3',
            'email' => 'client3@example.com',
            'password' => Hash::make('password'),
            'role' => 'client'
        ]);

        // Create 3 admins
        User::create([
            'lastName' => 'Admin1',
            'firstName' => 'User',
            'username' => 'admin1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'lastName' => 'Admin2',
            'firstName' => 'User',
            'username' => 'admin2',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'lastName' => 'Admin3',
            'firstName' => 'User',
            'username' => 'admin3',
            'email' => 'admin3@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Create 3 developers
        User::create([
            'lastName' => 'Developer1',
            'firstName' => 'User',
            'username' => 'developer1',
            'email' => 'developer1@example.com',
            'password' => Hash::make('password'),
            'role' => 'developer'
        ]);

        User::create([
            'lastName' => 'Developer2',
            'firstName' => 'User',
            'username' => 'developer2',
            'email' => 'developer2@example.com',
            'password' => Hash::make('password'),
            'role' => 'developer'
        ]);

        User::create([
            'lastName' => 'Developer3',
            'firstName' => 'User',
            'username' => 'developer3',
            'email' => 'developer3@example.com',
            'password' => Hash::make('password'),
            'role' => 'developer'
        ]);
    }
}
