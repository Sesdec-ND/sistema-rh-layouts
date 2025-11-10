<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vinculo;

class VinculoSeeder extends Seeder
{
    public function run()
    {
        $vinculos = [
            ['nome_vinculo' => 'Efetivo', 'descricao' => 'Servidor efetivo'],
            ['nome_vinculo' => 'Comissionado', 'descricao' => 'Servidor comissionado'],
            ['nome_vinculo' => 'Voluntário', 'descricao' => 'Servidor voluntário'],
            ['nome_vinculo' => 'PVSA', 'descricao' => 'Programa Voluntário'],
            ['nome_vinculo' => 'Temporário', 'descricao' => 'Servidor temporário'],
            ['nome_vinculo' => 'Estagiário', 'descricao' => 'Estagiário'],
        ];

        foreach ($vinculos as $vinculo) {
            Vinculo::create($vinculo);
        }
    }
}