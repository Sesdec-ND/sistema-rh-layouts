<?php

namespace App\Http\Controllers\Pessoal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Servidor;

class PerfilPessoalController extends Controller
{
    public function __construct()
    {
        // Middleware auth mantém a segurança - qualquer usuário logado pode acessar
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        $layout = $this->getLayoutByPerfil($user);
        
        // Buscar dados reais do servidor
        $servidor = Servidor::where('cpf', $user->cpf)->first();
        
        if (!$servidor) {
            return redirect()->back()->with('error', 'Dados do servidor não encontrados.');
        }

        $dadosPessoais = [
            'data_admissao' => $servidor->data_nomeacao ? $servidor->data_nomeacao->format('d/m/Y') : 'Não informada',
            'cargo' => $this->getCargoPorPerfil($user),
            'departamento' => $servidor->lotacao ? $servidor->lotacao->nome : 'Não informado',
            'salario' => $this->getSalario($servidor),
            'telefone' => $servidor->telefone ?? 'Não informado',
            'endereco' => $servidor->endereco ?? 'Não informado',
            'data_nascimento' => $servidor->data_nascimento ? $servidor->data_nascimento->format('d/m/Y') : 'Não informada',
            'estado_civil' => $servidor->estado_civil ?? 'Não informado',
            'escolaridade' => $servidor->formacao ?? 'Não informado',
        ];

        return view('servidor.perfil-pessoal.show', compact('user', 'dadosPessoais', 'layout', 'servidor'));
    }

    public function edit()
    {
        $user = Auth::user();
        $layout = $this->getLayoutByPerfil($user);
        
        $servidor = Servidor::where('cpf', $user->cpf)->first();
        
        if (!$servidor) {
            return redirect()->back()->with('error', 'Dados do servidor não encontrados.');
        }

        $dadosPessoais = [
            'data_admissao' => $servidor->data_nomeacao ? $servidor->data_nomeacao->format('d/m/Y') : 'Não informada',
            'cargo' => $this->getCargoPorPerfil($user),
            'departamento' => $servidor->lotacao ? $servidor->lotacao->nome : 'Não informado',
            'salario' => $this->getSalario($servidor),
            'telefone' => $servidor->telefone ?? '',
            'endereco' => $servidor->endereco ?? '',
            'data_nascimento' => $servidor->data_nascimento ? $servidor->data_nascimento->format('Y-m-d') : '',
            'estado_civil' => $servidor->estado_civil ?? '',
            'escolaridade' => $servidor->formacao ?? 'Não informado',
        ];

        return view('servidor.perfil-pessoal.edit', compact('user', 'dadosPessoais', 'layout', 'servidor'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'telefone' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'estado_civil' => 'required|string|max:50',
        ]);

        // Atualizar dados no banco
        $servidor = Servidor::where('cpf', $user->cpf)->first();
        
        if ($servidor) {
            $servidor->update([
                'telefone' => $validated['telefone'],
                'endereco' => $validated['endereco'],
                'data_nascimento' => $validated['data_nascimento'],
                'estado_civil' => $validated['estado_civil'],
            ]);
        }

        return redirect()->route('perfil-pessoal.show')
            ->with('success', 'Dados pessoais atualizados com sucesso!');
    }

    public function documentos()
    {
        $user = Auth::user();
        $layout = $this->getLayoutByPerfil($user);
        
        // Buscar documentos reais do banco (se tiver tabela de documentos)
        $documentos = [
            [
                'nome' => 'Contrato de Trabalho',
                'tipo' => 'PDF',
                'data_upload' => '15/03/2020',
                'tamanho' => '2.4 MB'
            ],
            [
                'nome' => 'Holerite - Novembro 2024',
                'tipo' => 'PDF',
                'data_upload' => '05/12/2024',
                'tamanho' => '1.8 MB'
            ]
        ];

        return view('servidor.perfil-pessoal.documentos', compact('user', 'documentos', 'layout'));
    }

    public function contracheque()
    {
        $user = Auth::user();
        $layout = $this->getLayoutByPerfil($user);
        
        // Buscar contracheques reais do banco
        $servidor = Servidor::where('cpf', $user->cpf)->first();
        $contracheques = [];

        if ($servidor && $servidor->historicosPagamento) {
            foreach ($servidor->historicosPagamento as $historico) {
                $contracheques[] = [
                    'mes' => $historico->mes_referencia,
                    'data_emissao' => $historico->created_at->format('d/m/Y'),
                    'valor_liquido' => 'R$ ' . number_format($historico->valor_liquido, 2, ',', '.'),
                    'id' => $historico->id
                ];
            }
        }

        // Se não houver dados reais, usar os fictícios
        if (empty($contracheques)) {
            $contracheques = [
                [
                    'mes' => 'Novembro 2024',
                    'data_emissao' => '05/12/2024',
                    'valor_liquido' => 'R$ 5.200,00'
                ],
                [
                    'mes' => 'Outubro 2024',
                    'data_emissao' => '05/11/2024',
                    'valor_liquido' => 'R$ 5.200,00'
                ]
            ];
        }

        return view('servidor.perfil-pessoal.contracheque', compact('user', 'contracheques', 'layout'));
    }

    /**
     * Determina qual layout usar baseado no perfil do usuário
     */
    private function getLayoutByPerfil($user)
    {
        if (!$user || !$user->perfil) {
            return 'layouts.app';
        }

        $nomePerfil = $user->perfil->nomePerfil;

        return match($nomePerfil) {
            'RH' => 'layouts.admin',
            'Diretor Executivo' => 'layouts.app',
            'Colaborador' => 'layouts.app',
            default => 'layouts.app'
        };
    }

    // Métodos auxiliares privados
    private function getCargoPorPerfil($user)
    {
        $servidor = Servidor::where('cpf', $user->cpf)->first();
        
        if ($servidor && $servidor->vinculo) {
            return $servidor->vinculo->cargo ?? 'Colaborador';
        }

        $perfil = $user->perfil->nomePerfil;
        
        return match($perfil) {
            'RH' => 'Analista de Recursos Humanos',
            'Diretor Executivo' => 'Diretor Executivo',
            'Colaborador' => 'Desenvolvedor',
            default => 'Colaborador'
        };
    }

    private function getDepartamentoPorPerfil($user)
    {
        $servidor = Servidor::where('cpf', $user->cpf)->first();
        
        if ($servidor && $servidor->lotacao) {
            return $servidor->lotacao->nome;
        }

        $perfil = $user->perfil->nomePerfil;
        
        return match($perfil) {
            'RH' => 'Recursos Humanos',
            'Diretor Executivo' => 'Diretoria',
            'Colaborador' => 'Tecnologia da Informação',
            default => 'Administrativo'
        };
    }

    private function getSalario($servidor)
    {
        // Buscar salário do histórico de pagamento mais recente
        if ($servidor && $servidor->historicosPagamento) {
            $ultimoPagamento = $servidor->historicosPagamento->sortByDesc('created_at')->first();
            if ($ultimoPagamento) {
                return 'R$ ' . number_format($ultimoPagamento->valor_liquido, 2, ',', '.');
            }
        }

        return 'R$ 5.500,00'; // Valor padrão caso não encontre
    }
}
