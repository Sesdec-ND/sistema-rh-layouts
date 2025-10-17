<?php

namespace App\Http\Controllers\Pessoal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        // Dados fictícios - em sistema real, viriam do banco
        $dadosPessoais = [
            'data_admissao' => '15/03/2020',
            'cargo' => $this->getCargoPorPerfil($user),
            'departamento' => $this->getDepartamentoPorPerfil($user),
            'salario' => 'R$ 5.500,00',
            'telefone' => '(11) 99999-9999',
            'endereco' => 'Rua Exemplo, 123 - São Paulo/SP',
            'data_nascimento' => '15/08/1985',
            'estado_civil' => 'Casado(a)',
            'escolaridade' => 'Ensino Superior Completo',
        ];

        return view('servidor.perfil-pessoal.show', compact('user', 'dadosPessoais', 'layout'));
    }

    public function edit()
    {
        $user = Auth::user();
        $layout = $this->getLayoutByPerfil($user);
        
        $dadosPessoais = [
        'data_admissao' => '15/03/2020',
        'cargo' => $this->getCargoPorPerfil($user),
        'departamento' => $this->getDepartamentoPorPerfil($user),
        'salario' => 'R$ 5.500,00',
        'telefone' => '(11) 99999-9999',
        'endereco' => 'Rua Exemplo, 123 - São Paulo/SP',
        'data_nascimento' => '1985-08-15', // formato YYYY-MM-DD para input date
        'estado_civil' => 'Casado(a)',
        'escolaridade' => 'Ensino Superior Completo',
    ];

        return view('servidor.perfil-pessoal.edit', compact('user', 'dadosPessoais', 'layout'));
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

        // Em sistema real, salvaria no banco
        // Por enquanto, apenas redireciona com mensagem

        return redirect()->route('perfil-pessoal.show')
            ->with('success', 'Dados pessoais atualizados com sucesso!');
    }

    public function documentos()
    {
        $user = Auth::user();
        $layout = $this->getLayoutByPerfil($user);
        
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

        return view('servidor.perfil-pessoal.contracheque', compact('user', 'contracheques', 'layout'));
    }

    /**
     * Determina qual layout usar baseado no perfil do usuário
     * RH e Diretor usam layout.admin
     * Colaborador usa layout.app
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
        $perfil = $user->perfil->nomePerfil;
        
        return match($perfil) {
            'RH' => 'Recursos Humanos',
            'Diretor Executivo' => 'Diretoria',
            'Colaborador' => 'Tecnologia da Informação',
            default => 'Administrativo'
        };
    }
}
