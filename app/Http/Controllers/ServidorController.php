<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use App\Models\Lotacao;
use App\Models\Vinculo;
use App\Models\Dependente;
use App\Models\Ocorrencia;
use App\Models\HistoricoPagamento;
use App\Models\Ferias;
use App\Models\Formacao;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ServidorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            // Middleware para verificar se é RH ou Admin
            $user = Auth::user();
            $perfil = $user->perfil->nomePerfil ?? '';
            
            if (!in_array($perfil, ['RH', 'Administrador'])) {
                abort(403, 'Acesso não autorizado.');
            }
            
            return $next($request);
        });
    }

    public function index()
    {
        $servidores = Servidor::with(['lotacao', 'vinculo', 'dependentes'])
                            ->latest()
                            ->paginate(10);

        // return view('servidor.colaboradores.index', compact('servidores'));
    }
    /**
     * Mostrar formulário de criação
     */
    public function create()
    {
        $lotacoes = Lotacao::where('status', true)->get();
        $vinculos = Vinculo::all();
        
        return view('servidor.colaboradores.create', compact('lotacoes', 'vinculos'));
    }
    /**
     * Salvar novo servidor
     */
    public function store(Request $request)
    {
        // Validação dos dados principais
        $validated = $request->validate([
            'matricula' => 'required|max:20|unique:servidores',
            'nomeCompleto' => 'required|max:255',
            'cpf' => 'required|max:14|unique:servidores',
            'rg' => 'required|max:20',
            'dataNascimento' => 'required|date',
            'genero' => 'required|in:Masculino,Feminino,Outro',
            'estadoCivil' => 'required',
            'telefone' => 'nullable|max:20',
            'endereco' => 'nullable|max:500',
            'racaCor' => 'nullable',
            'tipoSanguineo' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'formacao' => 'nullable|string|max:255',
            'pisPasep' => 'nullable|string|max:50',
            'dataNomeacao' => 'nullable|date',
            'idVinculo' => 'nullable|exists:vinculos,idVinculo',
            'idLotacao' => 'nullable|exists:lotacoes,idLotacao',
            
            // Arrays para campos dinâmicos
            'dependentes' => 'nullable|array',
            'dependentes.*.nome' => 'required_with:dependentes|string|max:255',
            'dependentes.*.data_nascimento' => 'required_with:dependentes|date',
            'dependentes.*.cpf' => 'nullable|string|max:14',
            'dependentes.*.parentesco' => 'required_with:dependentes|string|max:50',
            'dependentes.*.genero' => 'required_with:dependentes|string|max:20',
            
            'ocorrencias' => 'nullable|array',
            'ocorrencias.*.tipo_ocorrencia' => 'required_with:ocorrencias|string|max:255',
            'ocorrencias.*.data_inicio' => 'required_with:ocorrencias|date',
            'ocorrencias.*.data_fim' => 'nullable|date',
            'ocorrencias.*.descricao' => 'nullable|string',
            'ocorrencias.*.responsavel' => 'required_with:ocorrencias|string|max:255',
            
            'historico_pagamentos' => 'nullable|array',
            'historico_pagamentos.*.mes_competencia' => 'required_with:historico_pagamentos|string|max:20',
            'historico_pagamentos.*.ano_competencia' => 'required_with:historico_pagamentos|string|max:4',
            'historico_pagamentos.*.valor_bruto' => 'required_with:historico_pagamentos|numeric',
            'historico_pagamentos.*.valor_liquido' => 'required_with:historico_pagamentos|numeric',
            'historico_pagamentos.*.natureza_pagamento' => 'required_with:historico_pagamentos|string|max:255',
            'historico_pagamentos.*.descricao' => 'nullable|string',
            
            'ferias' => 'nullable|array',
            'ferias.*.ano_exercicio' => 'required_with:ferias|date',
            'ferias.*.periodo_inicio' => 'required_with:ferias|date',
            'ferias.*.periodo_fim' => 'required_with:ferias|date',
            'ferias.*.descricao' => 'nullable|string',
            'ferias.*.status' => 'required_with:ferias|string|max:50',
            
            'formacoes' => 'nullable|array',
            'formacoes.*.nome_curso' => 'required_with:formacoes|string|max:255',
            'formacoes.*.instituicao' => 'required_with:formacoes|string|max:255',
            'formacoes.*.ano_conclusao' => 'required_with:formacoes|string|max:4',
            'formacoes.*.nivel' => 'required_with:formacoes|string|max:100',
            
            'cursos' => 'nullable|array',
            'cursos.*.nome_curso' => 'required_with:cursos|string|max:255',
            'cursos.*.instituicao' => 'required_with:cursos|string|max:255',
            'cursos.*.carga_horaria' => 'required_with:cursos|integer',
            'cursos.*.data_conclusao' => 'required_with:cursos|date',
        ]);

        DB::beginTransaction();
        try {
            // Mapeia os nomes do formulário para o banco
            $servidorData = [
                'matricula' => $validated['matricula'],
                'nome_completo' => $validated['nomeCompleto'],
                'cpf' => $validated['cpf'],
                'rg' => $validated['rg'],
                'data_nascimento' => $validated['dataNascimento'],
                'genero' => $validated['genero'],
                'estado_civil' => $validated['estadoCivil'],
                'telefone' => $validated['telefone'] ?? null,
                'endereco' => $validated['endereco'] ?? null,
                'raca_cor' => $validated['racaCor'] ?? null,
                'tipo_sanguineo' => $validated['tipoSanguineo'] ?? null,
                'formacao' => $validated['formacao'] ?? null,
                'pis_pasep' => $validated['pisPasep'] ?? null,
                'data_nomeacao' => $validated['dataNomeacao'] ?? null,
                'id_vinculo' => $validated['idVinculo'] ?? null,
                'id_lotacao' => $validated['idLotacao'] ?? null,
                'status' => true, // Ativo por padrão
            ];

            // Upload da foto
            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('servidores', 'public');
                $servidorData['foto'] = $path;
            }

            // Cria o servidor
            $servidor = Servidor::create($servidorData);

            // Salva os relacionamentos
            $this->salvarRelacionamentos($servidor, $validated);

            DB::commit();

            return redirect()->route('servidores.index')
                ->with('success', 'Servidor cadastrado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Falha ao cadastrar o servidor: '.$e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $servidor = Servidor::with([
            'lotacao', 
            'vinculo', 
            'dependentes',
            'ocorrencias',
            'historicosPagamento',
            'ferias',
            'formacoes',
            'cursos'
        ])->findOrFail($id);

        return view('servidor.colaboradores.show', compact('servidor'));
    }

    public function edit($id)
    {
        $servidor = Servidor::with([
            'dependentes',
            'ocorrencias',
            'historicosPagamento',
            'ferias',
            'formacoes',
            'cursos'
        ])->findOrFail($id);
        
        $lotacoes = Lotacao::where('status', true)->get();
        $vinculos = Vinculo::all();

        return view('servidor.colaboradores.edit', compact('servidor', 'lotacoes', 'vinculos'));
    }

    public function update(Request $request, $id)
    {
        $servidor = Servidor::findOrFail($id);

        $validated = $request->validate([
            'matricula' => 'required|max:20|unique:servidores,matricula,'.$servidor->id,
            'nomeCompleto' => 'required|max:255',
            'cpf' => 'required|max:14|unique:servidores,cpf,'.$servidor->id,
            'rg' => 'required|max:20',
            'dataNascimento' => 'required|date',
            'genero' => 'required|in:Masculino,Feminino,Outro',
            'estadoCivil' => 'required',
            'telefone' => 'nullable|max:20',
            'endereco' => 'nullable|max:500',
            'racaCor' => 'nullable',
            'tipoSanguineo' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'formacao' => 'nullable|string|max:255',
            'pisPasep' => 'nullable|string|max:50',
            'dataNomeacao' => 'nullable|date',
            'idVinculo' => 'nullable|exists:vinculos,idVinculo',
            'idLotacao' => 'nullable|exists:lotacoes,idLotacao',
            'status' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            // Mapear dados
            $servidorData = [
                'matricula' => $validated['matricula'],
                'nome_completo' => $validated['nomeCompleto'],
                'cpf' => $validated['cpf'],
                'rg' => $validated['rg'],
                'data_nascimento' => $validated['dataNascimento'],
                'genero' => $validated['genero'],
                'estado_civil' => $validated['estadoCivil'],
                'telefone' => $validated['telefone'],
                'endereco' => $validated['endereco'],
                'raca_cor' => $validated['racaCor'],
                'tipo_sanguineo' => $validated['tipoSanguineo'],
                'formacao' => $validated['formacao'],
                'pis_pasep' => $validated['pisPasep'],
                'data_nomeacao' => $validated['dataNomeacao'],
                'id_vinculo' => $validated['idVinculo'],
                'id_lotacao' => $validated['idLotacao'],
                'status' => $validated['status'],
            ];

            // Upload da foto
            if ($request->hasFile('foto')) {
                // Remove foto antiga
                if ($servidor->foto) {
                    Storage::disk('public')->delete($servidor->foto);
                }
                $servidorData['foto'] = $request->file('foto')->store('servidores', 'public');
            }

            $servidor->update($servidorData);

            DB::commit();

            return redirect()->route('servidores.index')
                ->with('success', 'Servidor atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Falha ao atualizar o servidor: '.$e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $servidor = Servidor::findOrFail($id);
        $servidor->delete();

        return redirect()->route('servidores.index')
            ->with('success', 'Servidor removido com sucesso!');
    }

    public function trashed()
    {
        $servidores = Servidor::onlyTrashed()
                            ->with(['lotacao', 'vinculo'])
                            ->latest()
                            ->paginate(10);

        return view('servidor.colaboradores.trashed', compact('servidores'));
    }

    public function restore($id)
    {
        $servidor = Servidor::onlyTrashed()->findOrFail($id);
        $servidor->restore();

        return redirect()->route('servidores.trashed')
            ->with('success', 'Servidor restaurado com sucesso!');
    }

    public function forceDelete($id)
    {
        $servidor = Servidor::onlyTrashed()->findOrFail($id);

        // Remove foto apenas na exclusão permanente
        if ($servidor->foto) {
            Storage::disk('public')->delete($servidor->foto);
        }

        $servidor->forceDelete();

        return redirect()->route('servidores.trashed')
            ->with('success', 'Servidor excluído permanentemente!');
    }

    /**
     * Salva os relacionamentos do servidor
     */
    private function salvarRelacionamentos(Servidor $servidor, array $validated)
    {
        // Dependentes
        if (isset($validated['dependentes'])) {
            foreach ($validated['dependentes'] as $dependente) {
                if (!empty($dependente['nome'])) {
                    Dependente::create([
                        'idServidor' => $servidor->id,
                        'nome' => $dependente['nome'],
                        'parentesco' => $dependente['parentesco'],
                        'dataNascimento' => $dependente['data_nascimento'],
                        'cpf' => $dependente['cpf'] ?? null,
                        'genero' => $dependente['genero'],
                    ]);
                }
            }
        }

        // Ocorrências
        if (isset($validated['ocorrencias'])) {
            foreach ($validated['ocorrencias'] as $ocorrencia) {
                if (!empty($ocorrencia['tipo_ocorrencia'])) {
                    Ocorrencia::create([
                        'idServidor' => $servidor->id,
                        'tipoOcorrencia' => $ocorrencia['tipo_ocorrencia'],
                        'dataInicio' => $ocorrencia['data_inicio'],
                        'dataFim' => $ocorrencia['data_fim'] ?? null,
                        'descricao' => $ocorrencia['descricao'] ?? null,
                        'responsavelRegistro' => $ocorrencia['responsavel'],
                    ]);
                }
            }
        }

        // Histórico de Pagamentos
        if (isset($validated['historico_pagamentos'])) {
            foreach ($validated['historico_pagamentos'] as $pagamento) {
                if (!empty($pagamento['mes_competencia'])) {
                    HistoricoPagamento::create([
                        'idServidor' => $servidor->id,
                        'mesCompetencia' => $pagamento['mes_competencia'],
                        'anoCompetencia' => $pagamento['ano_competencia'],
                        'valorBruto' => $pagamento['valor_bruto'],
                        'valorLiquido' => $pagamento['valor_liquido'],
                        'naturezaPagamento' => $pagamento['natureza_pagamento'],
                        'descricao' => $pagamento['descricao'] ?? null,
                    ]);
                }
            }
        }

        // Férias
        if (isset($validated['ferias'])) {
            foreach ($validated['ferias'] as $ferias) {
                if (!empty($ferias['ano_exercicio'])) {
                    Ferias::create([
                        'idServidor' => $servidor->id,
                        'anoExercicio' => $ferias['ano_exercicio'],
                        'periodoInicio' => $ferias['periodo_inicio'],
                        'periodoFim' => $ferias['periodo_fim'],
                        'descricao' => $ferias['descricao'] ?? null,
                        'status' => $ferias['status'],
                    ]);
                }
            }
        }

        // Formações
        if (isset($validated['formacoes'])) {
            foreach ($validated['formacoes'] as $formacao) {
                if (!empty($formacao['nome_curso'])) {
                    Formacao::create([
                        'idServidor' => $servidor->id,
                        'nome_curso' => $formacao['nome_curso'],
                        'instituicao' => $formacao['instituicao'],
                        'ano_conclusao' => $formacao['ano_conclusao'],
                        'nivel' => $formacao['nivel'],
                    ]);
                }
            }
        }

        // Cursos
        if (isset($validated['cursos'])) {
            foreach ($validated['cursos'] as $curso) {
                if (!empty($curso['nome_curso'])) {
                    Curso::create([
                        'idServidor' => $servidor->id,
                        'nome_curso' => $curso['nome_curso'],
                        'instituicao' => $curso['instituicao'],
                        'carga_horaria' => $curso['carga_horaria'],
                        'data_conclusao' => $curso['data_conclusao'],
                    ]);
                }
            }
        }
    }
}
