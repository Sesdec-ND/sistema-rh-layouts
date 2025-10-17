<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ConfiguracoesSistemaController extends Controller
{
    public function index()
    {
        // Configurações em array (não precisamos de tabela)
        $configuracoes = [
            'geral' => [
                'nome_sistema' => config('app.name', 'Sistema RH'),
                'itens_por_pagina' => 15,
                'timezone' => 'America/Sao_Paulo',
                'idioma' => 'pt_BR'
            ],
            'seguranca' => [
                'tamanho_minimo_senha' => 8,
                'exigir_maiusculas' => true,
                'exigir_numeros' => true,
                'max_tentativas_login' => 5,
                'bloqueio_tempo_minutos' => 30
            ],
            'backup' => [
                'backup_automatico' => false,
                'frequencia_backup' => 'diario'
            ],
            'interface' => [
            'tema' => 'claro',
            'densidade' => 'confortavel'
            ],
            'sistema' => [
            'modo_manutencao' => false
            ]
        ];

        return view('admin.configuracoes-sistema', compact('configuracoes'));
    }

    public function update(Request $request)
    {
        // Aqui você pode salvar no .env, cache ou arquivo de configuração
        $configuracoes = $request->except('_token');
        
        // Exemplo: Salvar no cache (persistente)
        Cache::forever('configuracoes_sistema', $configuracoes);

        return redirect()->route('admin.configuracoes-sistema')
            ->with('success', 'Configurações atualizadas com sucesso!');
    }
}