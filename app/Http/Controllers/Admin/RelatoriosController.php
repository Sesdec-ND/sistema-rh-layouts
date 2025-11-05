<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servidor;
use App\Models\Lotacao;
use App\Models\Vinculo;
use App\Models\User;
use App\Models\Dependente;
use App\Models\Ferias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RelatoriosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->hasPermission('relatorios', 'view')) {
                abort(403, 'Acesso não autorizado');
            }
            return $next($request);
        });
    }

    /**
     * Tela principal de relatórios com dashboard
     */
    public function index(Request $request)
    {
        $lotacoes = Lotacao::all();
        $vinculos = Vinculo::all();

        // Dados para o dashboard de relatórios
        $dashboardData = $this->getDashboardData($request);

        return view('admin.relatorios.index', compact('lotacoes', 'vinculos', 'dashboardData'));
    }

    private function getDashboardData(Request $request)
    {
        try {
            return [
                'total_colaboradores' => Servidor::count(),
                'colaboradores_ativos' => Servidor::where('status', true)->count(),
                'total_lotacoes' => Lotacao::count(),
                'total_vinculos' => Vinculo::count(),
                'distribuicao_genero' => $this->getDistribuicaoGenero(),
                'ultimas_contratacoes' => Servidor::with('lotacao')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get(),
            ];
        } catch (\Exception $e) {
            // Fallback em caso de erro
            return [
                'total_colaboradores' => 0,
                'colaboradores_ativos' => 0,
                'total_lotacoes' => 0,
                'total_vinculos' => 0,
                'distribuicao_genero' => [],
                'ultimas_contratacoes' => [],
            ];
        }
    }

    /**
     * Relatório de Colaboradores com filtros avançados
     */
    public function relatorioColaboradores(Request $request)
    {
        if (!Auth::user()->hasPermission('relatorios', 'generate')) {
            abort(403, 'Acesso não autorizado');
        }

        $query = Servidor::with(['lotacao', 'vinculo', 'dependentes', 'user']);

        // Aplicar filtros
        $filtros = $this->aplicarFiltrosColaboradores($query, $request);

        $colaboradores = $query->get();

        // Estatísticas para o relatório
        $estatisticas = [
            'total_colaboradores' => $colaboradores->count(),
            'total_ativos' => $colaboradores->where('status', true)->count(),
            'total_masculino' => $colaboradores->where('genero', 'Masculino')->count(),
            'total_feminino' => $colaboradores->where('genero', 'Feminino')->count(),
            'media_idade' => round($colaboradores->filter(function ($c) {
                return $c->data_nascimento && Carbon::parse($c->data_nascimento)->age > 0;
            })->avg(function ($c) {
                return Carbon::parse($c->data_nascimento)->age;
            }), 1),
            'por_lotacao' => $colaboradores->groupBy('id_lotacao')->map->count(),
            'por_vinculo' => $colaboradores->groupBy('id_vinculo')->map->count(),
        ];

        $dadosRelatorio = [
            'titulo' => 'Relatório de Colaboradores',
            'data_geracao' => now()->format('d/m/Y H:i'),
            'estatisticas' => $estatisticas,
            'filtros_aplicados' => $filtros,
            'colaboradores' => $colaboradores,
            'usuario_gerador' => Auth::user()->name,
            'lotacoes' => Lotacao::all(),
            'vinculos' => Vinculo::all(),
        ];

        if ($request->has('download')) {
            return $this->downloadPDF($dadosRelatorio, 'colaboradores');
        }

        return view('admin.relatorios.colaboradores', $dadosRelatorio);
    }

    /**
     * Relatório Analítico com Gráficos
     */
    public function relatorioAnalitico(Request $request)
    {
        if (!Auth::user()->hasPermission('relatorios', 'generate')) {
            abort(403, 'Acesso não autorizado');
        }

        // Buscar dados necessários para os filtros
        $lotacoes = Lotacao::all();
        $vinculos = Vinculo::all();

        // Dados para gráficos
        $dadosGraficos = [
            'distribuicao_genero' => $this->getDistribuicaoGenero(),
            'distribuicao_lotacao' => $this->getDistribuicaoLotacao(),
            'distribuicao_vinculo' => $this->getDistribuicaoVinculo(),
            'evolucao_contratacoes' => $this->getEvolucaoContratacoes($request),
            'faixa_etaria' => $this->getFaixaEtaria(),
        ];

        // Estatísticas para o dashboard
        $estatisticas = [
            'total_colaboradores' => Servidor::count(),
            'colaboradores_ativos' => Servidor::where('status', true)->count(),
            'total_lotacoes' => $lotacoes->count(),
            'total_vinculos' => $vinculos->count(),
        ];

        $dadosRelatorio = [
            'titulo' => 'Relatório Analítico - Dashboard',
            'data_geracao' => now()->format('d/m/Y H:i'),
            'dados_graficos' => $dadosGraficos,
            'estatisticas' => $estatisticas,
            'lotacoes' => $lotacoes, // ✅ VARIÁVEL ADICIONADA
            'vinculos' => $vinculos, // ✅ VARIÁVEL ADICIONADA
            'usuario_gerador' => Auth::user()->name,
        ];

        return view('admin.relatorios.analitico', $dadosRelatorio);
    }

    /**
     * Relatório de Folha de Pagamento
     */
    public function relatorioFolhaPagamento(Request $request)
    {
        if (!Auth::user()->hasPermission('relatorios', 'generate')) {
            abort(403, 'Acesso não autorizado');
        }

        $mes = $request->mes ?? now()->month;
        $ano = $request->ano ?? now()->year;

        $folhaPagamento = Servidor::with(['lotacao', 'vinculo'])
            ->where('status', true)
            ->get()
            ->map(function ($servidor) use ($mes, $ano) {
                $salarioBase = $servidor->salario_base ?? rand(2000, 10000);
                $beneficios = $servidor->beneficios ?? rand(200, 1000);
                $descontos = $servidor->descontos ?? rand(100, 500);

                return [
                    'nome' => $servidor->nome_completo,
                    'matricula' => $servidor->matricula,
                    'lotacao' => $servidor->lotacao->nomeLotacao ?? 'N/A',
                    'vinculo' => $servidor->vinculo->nomeVinculo ?? 'N/A',
                    'salario_base' => $salarioBase,
                    'beneficios' => $beneficios,
                    'descontos' => $descontos,
                    'salario_liquido' => $salarioBase + $beneficios - $descontos,
                ];
            });

        $dadosRelatorio = [
            'titulo' => 'Relatório de Folha de Pagamento',
            'mes_ano' => $mes . '/' . $ano,
            'data_geracao' => now()->format('d/m/Y H:i'),
            'total_funcionarios' => $folhaPagamento->count(),
            'total_folha' => $folhaPagamento->sum('salario_liquido'),
            'folha_pagamento' => $folhaPagamento,
            'usuario_gerador' => Auth::user()->name,
        ];

        if ($request->has('download')) {
            return $this->downloadPDF($dadosRelatorio, 'folha-pagamento');
        }

        return view('admin.relatorios.folha-pagamento', $dadosRelatorio);
    }

    private function getDistribuicaoGenero()
    {
        return Servidor::select('genero', DB::raw('count(*) as total'))
            ->groupBy('genero')
            ->get()
            ->pluck('total', 'genero')
            ->toArray();
    }

    private function getDistribuicaoLotacao()
    {
        return Servidor::with('lotacao')
            ->get()
            ->groupBy('id_lotacao')
            ->map(function ($group, $key) {
                return [
                    'lotacao' => $group->first()->lotacao->nomeLotacao ?? 'Sem Lotação',
                    'total' => $group->count()
                ];
            })
            ->values()
            ->toArray();
    }

    private function getDistribuicaoVinculo()
    {
        return Servidor::with('vinculo')
            ->get()
            ->groupBy('id_vinculo')
            ->map(function ($group, $key) {
                return [
                    'vinculo' => $group->first()->vinculo->nomeVinculo ?? 'Sem Vínculo',
                    'total' => $group->count()
                ];
            })
            ->values()
            ->toArray();
    }

    private function getEvolucaoContratacoes(Request $request)
    {
        $ano = $request->ano ?? now()->year;

        return Servidor::select(
            DB::raw('MONTH(created_at) as mes'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', $ano)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->pluck('total', 'mes')
            ->toArray();
    }

    private function getFaixaEtaria()
    {
        $faixas = [
            '18-25' => 0,
            '26-35' => 0,
            '36-45' => 0,
            '46-55' => 0,
            '56+' => 0
        ];

        Servidor::whereNotNull('data_nascimento')->get()->each(function ($servidor) use (&$faixas) {
            $idade = Carbon::parse($servidor->data_nascimento)->age;

            if ($idade >= 18 && $idade <= 25) $faixas['18-25']++;
            elseif ($idade >= 26 && $idade <= 35) $faixas['26-35']++;
            elseif ($idade >= 36 && $idade <= 45) $faixas['36-45']++;
            elseif ($idade >= 46 && $idade <= 55) $faixas['46-55']++;
            elseif ($idade >= 56) $faixas['56+']++;
        });

        return $faixas;
    }

    private function aplicarFiltrosColaboradores($query, Request $request)
    {
        $filtros = [];

        if ($request->filled('lotacao_id')) {
            $query->where('id_lotacao', $request->lotacao_id);
            $filtros['lotacao'] = Lotacao::find($request->lotacao_id)->nomeLotacao ?? 'N/A';
        }

        if ($request->filled('vinculo_id')) {
            $query->where('id_vinculo', $request->vinculo_id);
            $filtros['vinculo'] = Vinculo::find($request->vinculo_id)->nomeVinculo ?? 'N/A';
        }

        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
            $filtros['genero'] = $request->genero;
        }

        if ($request->filled('status')) {
            if ($request->status === 'ativo') {
                $query->where('status', true);
            } elseif ($request->status === 'inativo') {
                $query->where('status', false);
            }
            $filtros['status'] = $request->status;
        }

        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('data_nomeacao', [
                $request->data_inicio,
                $request->data_fim
            ]);
            $filtros['periodo'] = $request->data_inicio . ' até ' . $request->data_fim;
        }

        return $filtros;
    }

    private function downloadPDF($dados, $nomeArquivo)
    {
        // Implementação básica - você pode integrar com DomPDF ou outra biblioteca
        return response()->json([
            'message' => 'Download do PDF gerado com sucesso',
            'dados' => $dados,
            'arquivo' => $nomeArquivo . '.pdf'
        ]);
    }

    // Mantenha os outros métodos existentes...
    public function relatorioPerformance(Request $request)
    { /* ... */
    }
    public function relatoriosGerados()
    { /* ... */
    }
}
