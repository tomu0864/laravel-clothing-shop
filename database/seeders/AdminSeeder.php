<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [
            [
                'name' => 'Admin',
                'email' => 'admin@gamil.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'updated_at' => Now(),
                'created_at' => Now()
            ]
        ];

        User::insert($admin);
    }
}
