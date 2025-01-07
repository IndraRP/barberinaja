<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Direktur',
                'email' => 'direktur@gmail.com',
                'role' => 'owner'
            ],
            [
                'name' => 'Staf',
                'email' => 'barber@gmail.com',
                'role' => 'barber'
            ],
            [
                'name' => 'Pelanggan',
                'email' => 'pelanggan@gmail.com',
                'role' => 'customer'
            ]
        ];

        foreach ($datas as $data) {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make(12345678),
                'role' => $data['role']
            ]);
        }
    }
}
