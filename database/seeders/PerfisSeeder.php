<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfisSeeder extends Seeder
{
    public function run(): void
    {
        $perfis = [
            [
                'nomePerfil' => 'RH',
                'descricao' => 'Acesso completo ao sistema de RH',
                'permissoes' => json_encode([
                    'dashboard' => true,
                    'colaboradores' => ['view', 'create', 'edit', 'delete'],
                    'relatorios' => true,
                    'configuracoes' => true
                ])
            ],
            [
                'nomePerfil' => 'Diretor Executivo',
                'descricao' => 'Acesso de visualização aos dados',
                'permissoes' => json_encode([
                    'dashboard' => true,
                    'colaboradores' => ['view'],
                    'relatorios' => true,
                    'configuracoes' => false
                ])
            ],
            [
                'nomePerfil' => 'Colaborador',
                'descricao' => 'Acesso limitado ao próprio perfil',
                'permissoes' => json_encode([
                    'dashboard' => true,
                    'colaboradores' => ['view_self'],
                    'relatorios' => false,
                    'configuracoes' => false
                ])
            ]
        ];

        DB::table('perfis')->insert($perfis);
    }
}
