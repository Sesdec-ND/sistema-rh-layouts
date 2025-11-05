<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vinculo;

class VinculoSeeder extends Seeder
{
    public function run()
    {
        $vinculos = [
            ['nomeVinculo' => 'Efetivo', 'descricao' => 'Servidor efetivo'],
            ['nomeVinculo' => 'Comissionado', 'descricao' => 'Servidor comissionado'],
            ['nomeVinculo' => 'Voluntário', 'descricao' => 'Servidor voluntário'],
            ['nomeVinculo' => 'PVSA', 'descricao' => 'Programa Voluntário'],
            ['nomeVinculo' => 'Temporário', 'descricao' => 'Servidor temporário'],
            ['nomeVinculo' => 'Estagiário', 'descricao' => 'Estagiário'],
        ];

        foreach ($vinculos as $vinculo) {
            Vinculo::create($vinculo);
        }
    }
}