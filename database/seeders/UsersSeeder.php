<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // É uma boa prática usar o Model

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // O array de usuários está perfeito. Nenhuma mudança aqui.
        $users = [
            [
                'name' => 'Administrador RH',
                'email' => 'rh@sistema.com',
                'cpf' => '123.456.789-00',
                'rg' => '12345678',
                'username' => 'admin_rh',
                'password' => Hash::make('senha123'),
                'perfil_id' => 1, // RH
            ],
            [
                'name' => 'Diretor Executivo',
                'email' => 'diretor@sistema.com',
                'cpf' => '987.654.321-00',
                'rg' => '87654321',
                'username' => 'diretor',
                'password' => Hash::make('senha123'),
                'perfil_id' => 2, // Diretor Executivo
            ],
            [
                'name' => 'Colaborador Exemplo',
                'email' => 'colaborador@sistema.com',
                'cpf' => '111.222.333-44',
                'rg' => '11222333',
                'username' => 'colaborador',
                'password' => Hash::make('senha123'),
                'perfil_id' => 3, // Colaborador
            ]
        ];

        // =================================================================
        // CÓDIGO MELHORADO - Use um loop com updateOrInsert
        // =================================================================
        foreach ($users as $userData) {
            // Usando o Model User, que é a forma mais "Eloquent" de fazer.
            User::updateOrInsert(
                // Condição para encontrar o usuário (um campo único como email ou cpf)
                ['email' => $userData['email']],
                // Dados para inserir ou atualizar
                $userData
            );
        }
    }
}
