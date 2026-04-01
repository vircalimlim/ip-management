<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Test Superadmin',
            'email' => 'supermeow@gmail.com',
            'role' => 'superadmin',
            'password' => Hash::make('pass@dev'),
        ]);

        User::create([
            'name' => 'Test Superadmin',
            'email' => 'supermeow2@gmail.com',
            'role' => 'superadmin',
            'password' => Hash::make('pass@dev'),
        ]);

        User::create([
            'name' => 'Test1 Admin1',
            'email' => 'adminmeow@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('pass@dev'),
        ]);

        User::create([
            'name' => 'Test2 Admin2',
            'email' => 'adminmeow2@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('pass@dev'),
        ]);

        User::create([
            'name' => 'Test3 Admin3',
            'email' => 'adminmeow3@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('pass@dev'),
        ]);
    }
}
