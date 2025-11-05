<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lotacao;

class LotacaoSeeder extends Seeder
{
    public function run()
    {
        $lotacoes = [
            ['nomeLotacao' => 'Polícia Militar', 'sigla' => 'PM', 'departamento' => 'Segurança Pública', 'localizacao' => 'Sede Central', 'status' => true],
            ['nomeLotacao' => 'Polícia Civil', 'sigla' => 'PC', 'departamento' => 'Segurança Pública', 'localizacao' => 'Sede Central', 'status' => true],
            ['nomeLotacao' => 'Polícia Técnica', 'sigla' => 'POLITEC', 'departamento' => 'Segurança Pública', 'localizacao' => 'Sede Central', 'status' => true],
            ['nomeLotacao' => 'Corpo de Bombeiros', 'sigla' => 'CBM', 'departamento' => 'Segurança Pública', 'localizacao' => 'Quartel Central', 'status' => true],
            ['nomeLotacao' => 'Administração Central', 'sigla' => 'ADM', 'departamento' => 'Administração', 'localizacao' => 'Sede Administrativa', 'status' => true],
            ['nomeLotacao' => 'Recursos Humanos', 'sigla' => 'RH', 'departamento' => 'Gestão de Pessoas', 'localizacao' => 'Sede Administrativa', 'status' => true],
        ];

        foreach ($lotacoes as $lotacao) {
            Lotacao::create($lotacao);
        }
    }
}