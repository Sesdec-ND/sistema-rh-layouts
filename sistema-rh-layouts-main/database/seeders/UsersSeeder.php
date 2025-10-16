<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrador RH',
                'email' => 'rh@sistema.com',
                'cpf' => '123.456.789-00',
                'rg' => '12345678',
                'username' => 'admin_rh',
                'password' => Hash::make('senha123'),
                'perfil_id' => 1, // RH
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Diretor Executivo',
                'email' => 'diretor@sistema.com',
                'cpf' => '987.654.321-00',
                'rg' => '87654321',
                'username' => 'diretor',
                'password' => Hash::make('senha123'),
                'perfil_id' => 2, // Diretor Executivo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Colaborador Exemplo',
                'email' => 'colaborador@sistema.com',
                'cpf' => '111.222.333-44',
                'rg' => '11222333',
                'username' => 'colaborador',
                'password' => Hash::make('senha123'),
                'perfil_id' => 3, // Colaborador
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('users')->insert($users);
    }
}
