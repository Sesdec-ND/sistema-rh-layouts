<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perfil;
use App\Models\Servidor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Lotacao;
use App\Models\Vinculo;

class RHController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->hasPermission('dashboard')) {
                abort(403, 'Acesso não autorizado');
            }
            return $next($request);
        });
    }

    public function index()
{
    // // $servidores = Servidor::with('perfil')->get();
    // // $lotacoes = Lotacao::where('status', true)->get();

    $vinculos = Vinculo::all();
    $servidores = Servidor::all();
    $lotacoes   = Lotacao::all();
    return view('admin.colaborador', compact('servidores', 'lotacoes', 'vinculos'));
}

    public function dashboard()
    {
        $totalColaboradores = User::count();
        $totalPerfis = Perfil::count();
        
        return view('admin.dashboard', compact('totalColaboradores', 'totalPerfis'));
    }

    /**
     * Lista de colaboradores - FOCO APENAS EM DADOS CADASTRAIS (MODIFICADO)
     */
    public function colaboradores()
    {
        if (!Auth::user()->hasPermission('colaboradores', 'view')) {
        abort(403, 'Acesso não autorizado');
    }

    // 2. Busque TODOS os dados que a view precisa
    $servidores = Servidor::all(); // A view espera '$servidores', não '$colaboradores'
    $lotacoes   = Lotacao::all();
    $vinculos   = Vinculo::all();

    // 3. Retorne a view e passe TODAS as variáveis necessárias
    return view('admin.colaborador', compact('servidores', 'lotacoes', 'vinculos'));
}
    /*
    public function relatorios()
    {
        if (!Auth::user()->hasPermission('relatorios')) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.relatorios');
    }
        */

    public function perfisAcesso()
    {
        if (!Auth::user()->hasPermission('perfis_acesso', 'view')) {
            abort(403, 'Acesso não autorizado');
        }

        $perfis = Perfil::all();
        return view('admin.perfis-acesso', compact('perfis'));
    }

    public function configuracoesSistema()
    {
        if (!Auth::user()->hasPermission('configuracoes_sistema', 'view')) {
            abort(403, 'Acesso não autorizado');
        }

        $configuracoes = [
            'geral' => [
                'itens_por_pagina' => 15,
                'timezone' => 'America/Sao_Paulo',
                'idioma' => 'pt_BR'
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

    public function seguranca()
    {
        if (!Auth::user()->hasPermission('seguranca', 'view_logs')) {
            abort(403, 'Acesso não autorizado');
        }

        $politicas = [
            'tamanho_minimo_senha' => 8,
            'exigir_maiusculas' => true,
            'exigir_numeros' => true,
            'max_tentativas_login' => 5,
            'bloqueio_tempo_minutos' => 30,
            'exigir_especiais' => false,
            'login_dois_fatores' => false
        ];

        return view('admin.politicas-seguranca', compact('politicas'));
    }
}