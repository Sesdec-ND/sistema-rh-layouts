<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servidor;
use App\Models\Lotacao;
use App\Models\Vinculo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
     * Tela principal de relatórios
     */
    public function index()
    {
        $lotacoes = Lotacao::all();
        $vinculos = Vinculo::all();

        return view('admin.relatorios.index', compact('lotacoes', 'vinculos'));
    }

    /**
     * Relatório de Colaboradores
     */
    public function relatorioColaboradores(Request $request)
    {
        if (!Auth::user()->hasPermission('relatorios', 'generate')) {
            abort(403, 'Acesso não autorizado');
        }

        // Buscar dados com relacionamentos
        $colaboradores = Servidor::with(['lotacao', 'vinculo'])->get();

        // Preparar dados garantindo que todos os campos existam
        $colaboradoresProcessados = $colaboradores->map(function ($servidor) {
            return (object) [
                'id' => $servidor->id,
                'nome' => $servidor->nome_completo ?? 'Nome não informado',
                'matricula' => $servidor->matricula ?? 'N/A',
                'lotacao' => $servidor->lotacao, // objeto completo do relacionamento
                'vinculo' => $servidor->vinculo, // objeto completo do relacionamento
                'status' => !empty($servidor->data_nomeacao) && empty($servidor->deleted_at),
                'data_nomeacao' => $servidor->data_nomeacao,
                'deleted_at' => $servidor->deleted_at,
            ];
        });

        $dadosRelatorio = [
            'titulo' => 'Relatório de Colaboradores',
            'data_geracao' => now()->format('d/m/Y H:i'),
            'total_colaboradores' => $colaboradoresProcessados->count(),
            'filtros_aplicados' => $this->aplicarFiltros($request),
            'colaboradores' => $colaboradoresProcessados,
            'usuario_gerador' => Auth::user()->name,
        ];

        if ($request->has('download')) {
            if (!Auth::user()->hasPermission('relatorios', 'download')) {
                abort(403, 'Acesso não autorizado para download');
            }
            return $this->downloadPDF($dadosRelatorio, 'relatorio-colaboradores');
        }

        return view('admin.relatorios.colaboradores', $dadosRelatorio);
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
                    'nome' => $servidor->nome,
                    'matricula' => $servidor->matricula,
                    'lotacao' => $servidor->lotacao->nome ?? 'N/A',
                    'vinculo' => $servidor->vinculo->nome ?? 'N/A',
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
            return $this->downloadPDF($dadosRelatorio, 'relatorio-folha-pagamento');
        }

        return view('admin.relatorios.folha-pagamento', $dadosRelatorio);
    }

    /**
     * Relatório de Performance
     */
    public function relatorioPerformance(Request $request)
    {
        if (!Auth::user()->hasPermission('relatorios', 'generate')) {
            abort(403, 'Acesso não autorizado');
        }

        $trimestre = $request->trimestre ?? ceil(now()->month / 3);
        $ano = $request->ano ?? now()->year;

        $performance = Servidor::with(['lotacao'])
            ->where('status', true)
            ->get()
            ->map(function ($servidor) {
                $avaliacao = rand(7, 10);
                $produtividade = rand(80, 100);
                $pontualidade = rand(85, 100);
                $media = ($avaliacao + $produtividade + $pontualidade) / 3;

                return [
                    'nome' => $servidor->nome,
                    'matricula' => $servidor->matricula,
                    'lotacao' => $servidor->lotacao->nome ?? 'N/A',
                    'avaliacao_desempenho' => $avaliacao,
                    'produtividade' => $produtividade,
                    'pontualidade' => $pontualidade,
                    'media_geral' => round($media, 1),
                ];
            });

        $dadosRelatorio = [
            'titulo' => 'Relatório de Performance',
            'trimestre_ano' => $trimestre . 'º Trimestre ' . $ano,
            'data_geracao' => now()->format('d/m/Y H:i'),
            'total_avaliados' => $performance->count(),
            'media_geral_empresa' => round($performance->avg('media_geral'), 1),
            'performance' => $performance,
            'usuario_gerador' => Auth::user()->name,
        ];

        if ($request->has('download')) {
            return $this->downloadPDF($dadosRelatorio, 'relatorio-performance');
        }

        return view('admin.relatorios.performance', $dadosRelatorio);
    }

    /**
     * Lista de relatórios gerados
     */
    public function relatoriosGerados()
    {
        // Em produção, isso viria de uma tabela de relatórios_gerados
        $relatorios = [
            [
                'id' => 1,
                'nome' => 'Colaboradores Ativos',
                'tipo' => 'colaboradores',
                'formato' => 'PDF',
                'data_geracao' => now()->subHours(2),
                'tamanho' => '2.4 MB',
                'status' => 'concluido',
                'gerado_por' => Auth::user()->name,
            ],
            [
                'id' => 2,
                'nome' => 'Folha de Pagamento - Nov/2024',
                'tipo' => 'folha_pagamento',
                'formato' => 'Excel',
                'data_geracao' => now()->subDays(1),
                'tamanho' => '1.8 MB',
                'status' => 'concluido',
                'gerado_por' => Auth::user()->name,
            ],
        ];

        return view('admin.relatorios.gerados', compact('relatorios'));
    }

    /**
     * Métodos auxiliares privados
     */
    private function aplicarFiltros(Request $request)
    {
        return [
            'lotacao_id' => $request->lotacao_id,
            'vinculo_id' => $request->vinculo_id,
            'status' => $request->status ?? 'ativo',
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
        ];
    }

    private function queryColaboradores($filtros)
    {
        $query = Servidor::with(['lotacao', 'vinculo', 'user']);

        if ($filtros['lotacao_id']) {
            $query->where('lotacao_id', $filtros['lotacao_id']);
        }

        if ($filtros['vinculo_id']) {
            $query->where('vinculo_id', $filtros['vinculo_id']);
        }

        if ($filtros['status'] === 'ativo') {
            $query->where('status', true);
        } elseif ($filtros['status'] === 'inativo') {
            $query->where('status', false);
        }

        return $query;
    }

    private function downloadPDF($dados, $nomeArquivo)
    {
        // Para debug - verifique se está chegando aqui
        \Log::info("Tentando baixar PDF: " . $nomeArquivo, $dados);

        $viewPDF = 'admin.relatorios.pdf.' . $nomeArquivo;
        $viewNormal = 'admin.relatorios.' . $nomeArquivo;

        // Verifica qual view existe
        if (view()->exists($viewPDF)) {
            return view($viewPDF, $dados);
        } elseif (view()->exists($viewNormal)) {
            return view($viewNormal, $dados);
        } else {
            // Fallback: retorna para a página com mensagem de erro
            return redirect()->back()->with('error', 'Template de relatório não encontrado: ' . $nomeArquivo);
        }
    }
}
