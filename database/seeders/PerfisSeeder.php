<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfisSeeder extends Seeder
{
    public function run(): void
    {
        // Array de perfis, exatamente como você já tinha.
        $perfis = [
            [
                'id' => 1,
                'nomePerfil' => 'RH',
                'descricao' => 'Acesso completo ao sistema de RH',
                'permissoes' => json_encode([
                    'dashboard' => true,
                    'colaboradores' => ['view', 'create', 'edit', 'delete'],
                    'relatorios' => ['view', 'generate', 'download', 'export'],
                    'perfis_acesso' => ['view', 'create', 'edit', 'delete', 'manage_permissions'],
                    'configuracoes_sistema' => ['view', 'edit'],
                    'seguranca' => ['view_logs', 'view_auditoria', 'manage_policies']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nomePerfil' => 'Diretor Executivo',
                'descricao' => 'Acesso de visualização aos dados',
                'permissoes' => json_encode([
                    'dashboard' => true,
                    'colaboradores' => ['view'],
                    'relatorios' => ['view', 'download'],
                    'perfis_acesso' => false,
                    'configuracoes_sistema' => false,
                    'seguranca' => false
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nomePerfil' => 'Colaborador',
                'descricao' => 'Acesso limitado ao próprio perfil',
                'permissoes' => json_encode([
                    'dashboard' => true,
                    'colaboradores' => ['view_self'],
                    'relatorios' => false,
                    'perfis_acesso' => false,
                    'configuracoes_sistema' => false,
                    'seguranca' => false
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // =================================================================
        // CÓDIGO CORRIGIDO - Use um loop com updateOrInsert
        // =================================================================
        foreach ($perfis as $perfil) {
            DB::table('perfis')->updateOrInsert(
                ['id' => $perfil['id']], // Condição para encontrar o registro (o identificador único)
                $perfil                  // Dados para inserir ou atualizar
            );
        }
    }
}