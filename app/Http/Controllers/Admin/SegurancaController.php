<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class SegurancaController extends Controller
{
    public function index()
    {
        // Redireciona para a página de políticas por padrão
        return redirect()->route('admin.seguranca.politicas');
    }

    public function politicas()
    {
        // Buscar políticas do cache ou usar padrões
        $politicas = Cache::get('configuracoes_sistema.seguranca', [
            'tamanho_minimo_senha' => 8,
            'exigir_maiusculas' => true,
            'exigir_numeros' => true,
            'max_tentativas_login' => 5,
            'bloqueio_tempo_minutos' => 30
        ]);

        return view('admin.politicas-seguranca', compact('politicas'));
    }

    public function logs()
    {
        // Ler logs do Laravel
        $logFile = storage_path('logs/laravel.log');
        $logs = [];
        
        if (File::exists($logFile)) {
            $logs = array_slice(file($logFile), -100); // Últimas 100 linhas
        }

        return view('admin.logs-sistema', compact('logs'));
    }

    public function auditoria()
    {
        // Buscar logs de atividades dos usuários
        // Você pode criar uma tabela de auditoria futuramente se necessário
        $atividades = DB::table('users')
            ->select('name', 'email', 'last_login_at', 'updated_at')
            ->whereNotNull('last_login_at')
            ->orderBy('last_login_at', 'desc')
            ->limit(50)
            ->get();

        return view('admin.auditoria', compact('atividades'));
    }

    public function updatePoliticas(Request $request)
    {
        $politicas = $request->validate([
            'tamanho_minimo_senha' => 'required|integer|min:6',
            'exigir_maiusculas' => 'boolean',
            'exigir_numeros' => 'boolean',
            'max_tentativas_login' => 'required|integer|min:1',
            'bloqueio_tempo_minutos' => 'required|integer|min:1'
        ]);

        // Salvar no cache
        $configuracoes = Cache::get('configuracoes_sistema', []);
        $configuracoes['seguranca'] = $politicas;
        Cache::forever('configuracoes_sistema', $configuracoes);

        return redirect()->route('admin.seguranca.politicas')
            ->with('success', 'Políticas de segurança atualizadas com sucesso!');
    }
}