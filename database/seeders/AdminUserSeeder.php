<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@bptdbali.com',
                'name' => 'Administrator',
                'password' => 'admin',
                'role' => UserRole::ADMIN,
            ],
            [
                'email' => 'kabalai@bptdbali.com',
                'name' => 'Kabalai',
                'password' => 'kabalai123',
                'role' => UserRole::KABALAI,
            ],
            [
                'email' => 'seksi@bptdbali.com',
                'name' => 'Petugas Seksi',
                'password' => 'seksi123',
                'role' => UserRole::SEKSI,
            ],
            [
                'email' => 'satpel@bptdbali.com',
                'name' => 'Petugas Satpel',
                'password' => 'satpel123',
                'role' => UserRole::SATPEL,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                    'role' => $user['role'],
                ]
            );
        }
    }
}