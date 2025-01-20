<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin =  User::create([
            'name' => 'adnan',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('000'),
            'photo' => 'images/users/defaultUser.png',
        ]);
        $admin->assignRole('admin');
    }
}
