<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ServidorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servidores = Servidor::all();
        return view('admin.colaborador', compact('servidores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perfis = \App\Models\Perfil::all();
        return view('servidor.colaboradores.create', compact('perfis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Dados recebidos no request:', $request->all());

        $validated = $request->validate([
            // Dados Pessoais
            'matricula' => 'required|string|max:20|unique:servidores,matricula',
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:servidores,email',
            'cpf' => 'required|string|max:14|unique:servidores,cpf',
            'rg' => 'required|string|max:20',
            'data_nascimento' => 'required|date',
            'genero' => 'required|in:Masculino,Feminino',
            'estado_civil' => 'nullable|string|max:50',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'raca_cor' => 'nullable|in:Branca,Preta,Parda,Amarela',
            'tipo_sanguineo' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'pispasep' => 'nullable|string|max:20',
            'data_nomeacao' => 'nullable|date',
            'status' => 'required|boolean',
            'id_vinculo' => 'nullable|exists:vinculos,id',
            'id_lotacao' => 'nullable|exists:lotacoes,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Validações para arrays dinâmicos
            'dependentes' => 'nullable|array',
            'dependentes.*.nome' => 'required|string|max:255',
            'dependentes.*.parentesco' => 'nullable|string|max:100',
            'dependentes.*.data_nascimento' => 'nullable|date',
            'dependentes.*.cpf' => 'nullable|string|max:14',

            'historicos_pagamento' => 'nullable|array',
            'historicos_pagamento.*.mes_ano' => 'required|date',
            'historicos_pagamento.*.valor' => 'required|numeric|min:0',
            'historicos_pagamento.*.status' => 'required|in:Pendente,Pago,Cancelado',
            'historicos_pagamento.*.observacoes' => 'nullable|string|max:500',

            'ferias' => 'nullable|array',
            'ferias.*.data_inicio' => 'required|date',
            'ferias.*.data_fim' => 'required|date',
            'ferias.*.dias' => 'nullable|integer|min:1',
            'ferias.*.status' => 'nullable|string|max:50',
            'ferias.*.observacoes' => 'nullable|string',

            'formacoes' => 'nullable|array',
            'formacoes.*.curso' => 'required|string|max:255',
            'formacoes.*.instituicao' => 'required|string|max:255',
            'formacoes.*.nivel' => 'nullable|string|max:100',
            'formacoes.*.ano_conclusao' => 'nullable|integer',

            'cursos' => 'nullable|array',
            'cursos.*.nome' => 'required|string|max:255',
            'cursos.*.instituicao' => 'required|string|max:255',
            'cursos.*.carga_horaria' => 'nullable|integer|min:1',
            'cursos.*.data_conclusao' => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {
            // Dados do servidor
            $servidorData = [
                'matricula' => $validated['matricula'],
                'nome_completo' => $validated['nome_completo'],
                'email' => $validated['email'],
                'cpf' => $validated['cpf'],
                'rg' => $validated['rg'],
                'data_nascimento' => $validated['data_nascimento'],
                'genero' => $validated['genero'],
                'estado_civil' => $validated['estado_civil'] ?? null,
                'telefone' => $validated['telefone'] ?? null,
                'endereco' => $validated['endereco'] ?? null,
                'raca_cor' => $validated['raca_cor'] ?? null,
                'tipo_sanguineo' => $validated['tipo_sanguineo'] ?? null,
                'pispasep' => $validated['pispasep'] ?? null,
                'data_nomeacao' => $validated['data_nomeacao'] ?? null,
                'status' => $validated['status'],
                'id_vinculo' => $validated['id_vinculo'] ?? null,
                'id_lotacao' => $validated['id_lotacao'] ?? null,
            ];

            // Processar foto
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoNome = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                $fotoPath = $foto->storeAs('servidores/fotos', $fotoNome, 'public');
                $servidorData['foto'] = $fotoPath;
            }

            // Criar servidor
            $servidor = Servidor::create($servidorData);

            // Processar dados das abas dinâmicas
            $this->processarAbasDinamicas($request, $servidor);

            DB::commit();

            return redirect()->route('servidores.show', $servidor->id)
                ->with('success', 'Servidor cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('ERRO no cadastro: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Erro ao cadastrar servidor: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function processarAbasDinamicas(Request $request, Servidor $servidor)
    {
        // Processar formações
        if ($request->has('formacoes')) {
            foreach ($request->formacoes as $formacaoData) {
                if (!empty($formacaoData['curso']) || !empty($formacaoData['instituicao'])) {
                    $servidor->formacoes()->create([
                        'curso' => $formacaoData['curso'] ?? null,
                        'instituicao' => $formacaoData['instituicao'] ?? null,
                        'nivel' => $formacaoData['nivel'] ?? null,
                        'ano_conclusao' => $formacaoData['ano_conclusao'] ?? null,
                    ]);
                }
            }
        }

        // Processar dependentes
        if ($request->has('dependentes')) {
            foreach ($request->dependentes as $dependenteData) {
                if (!empty($dependenteData['nome'])) {
                    $servidor->dependentes()->create([
                        'nome' => $dependenteData['nome'],
                        'parentesco' => $dependenteData['parentesco'] ?? null,
                        'data_nascimento' => $dependenteData['data_nascimento'] ?? null,
                        'cpf' => $dependenteData['cpf'] ?? null,
                    ]);
                }
            }
        }

        // Processar Histórico de Pagamento
        if ($request->has('historicos_pagamento')) {
            foreach ($request->historicos_pagamento as $pagamentoData) {
                if (!empty($pagamentoData['mes_ano']) && !empty($pagamentoData['valor'])) {
                    $servidor->historicosPagamento()->create([
                        'mes_ano' => $pagamentoData['mes_ano'],
                        'valor' => $pagamentoData['valor'],
                        'status' => $pagamentoData['status'],
                        'observacoes' => $pagamentoData['observacoes'] ?? null
                    ]);
                }
            }
        }

        // Processar Férias
        if ($request->has('ferias')) {
            foreach ($request->ferias as $feriasData) {
                if (!empty($feriasData['data_inicio']) || !empty($feriasData['data_fim'])) {
                    $servidor->ferias()->create([
                        'data_inicio' => $feriasData['data_inicio'] ?? null,
                        'data_fim' => $feriasData['data_fim'] ?? null,
                        'dias' => $feriasData['dias'] ?? 30,
                        'status' => $feriasData['status'] ?? 'Programada',
                        'observacoes' => $feriasData['observacoes'] ?? null,
                    ]);
                }
            }
        }

        // Processar Cursos
        if ($request->has('cursos')) {
            foreach ($request->cursos as $cursoData) {
                if (!empty($cursoData['nome']) || !empty($cursoData['instituicao'])) {
                    $servidor->cursos()->create([
                        'nome' => $cursoData['nome'] ?? null,
                        'instituicao' => $cursoData['instituicao'] ?? null,
                        'carga_horaria' => $cursoData['carga_horaria'] ?? null,
                        'data_conclusao' => $cursoData['data_conclusao'] ?? null,
                        'certificado' => $cursoData['certificado'] ?? null,
                    ]);
                }
            }
        }

        // Processar Lotação (se for dinâmica)
        if ($request->has('lotacoes')) {
            foreach ($request->lotacoes as $lotacaoData) {
                if (!empty($lotacaoData['nomeLotacao']) || !empty($lotacaoData['departamento'])) {
                    \App\Models\Lotacao::create([
                        'nomeLotacao' => $lotacaoData['nomeLotacao'] ?? null,
                        'sigla' => $lotacaoData['sigla'] ?? null,
                        'departamento' => $lotacaoData['departamento'] ?? null,
                        'localizacao' => $lotacaoData['localizacao'] ?? null,
                        'status' => $lotacaoData['status'] ?? true,
                    ]);
                }
            }
        }

        // Processar Vínculo (se for dinâmico)
        if ($request->has('vinculos')) {
            foreach ($request->vinculos as $vinculoData) {
                if (!empty($vinculoData['nomeVinculo']) || !empty($vinculoData['descricao'])) {
                    \App\Models\Vinculo::create([
                        'nomeVinculo' => $vinculoData['nomeVinculo'] ?? null,
                        'descricao' => $vinculoData['descricao'] ?? null,
                    ]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $servidor = Servidor::with([
            'lotacao',
            'vinculo',
            'dependentes',
            'historicosPagamento',
            'ferias',
            'formacoes',
            'cursos'
        ])->findOrFail($id);

        return view('servidor.colaboradores.show', compact('servidor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $servidor = Servidor::findOrFail($id);

            $lotacoes = \App\Models\Lotacao::all() ?? [];
            $vinculos = \App\Models\Vinculo::all() ?? [];

            return view('servidor.colaboradores.edit', compact('servidor', 'lotacoes', 'vinculos'));
        } catch (\Exception $e) {
            return redirect()->route('servidores.index')
                ->with('error', 'Servidor não encontrado.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Encontrar o servidor
        $servidor = Servidor::findOrFail($id);

        // Validação dos dados
        $validatedData = $request->validate([
            // Dados Pessoais
            'matricula' => 'required|string|max:50|unique:servidores,matricula,' . $id,
            'nome_completo' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:servidores,cpf,' . $id,
            'rg' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'data_nascimento' => 'required|date',
            'genero' => 'required|in:Masculino,Feminino',
            'estado_civil' => 'nullable|in:Solteiro,Casado,Divorciado,Viúvo',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:500',
            'raca_cor' => 'nullable|in:Branca,Preta,Parda,Amarela',
            'tipo_sanguineo' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Dados Funcionais
            'pispasep' => 'nullable|string|max:50',
            'data_nomeacao' => 'nullable|date',
            'status' => 'required|boolean',
            'id_vinculo' => 'nullable|exists:vinculos,id',
            'id_lotacao' => 'nullable|exists:lotacoes,id',
        ]);

        try {
            DB::beginTransaction();

            // Processar upload da foto se fornecida
            if ($request->hasFile('foto')) {
                // Deletar foto antiga se existir
                if ($servidor->foto && Storage::exists($servidor->foto)) {
                    Storage::delete($servidor->foto);
                }

                // Salvar nova foto
                $fotoPath = $request->file('foto')->store('fotos_servidores', 'public');
                $validatedData['foto'] = $fotoPath;
            } else {
                // Manter foto atual se não for enviada nova
                unset($validatedData['foto']);
            }

            // Converter dados para os formatos corretos
            $validatedData['data_nascimento'] = !empty($validatedData['data_nascimento'])
                ? Carbon::parse($validatedData['data_nascimento'])
                : null;

            $validatedData['data_nomeacao'] = !empty($validatedData['data_nomeacao'])
                ? Carbon::parse($validatedData['data_nomeacao'])
                : null;

            // Atualizar o servidor
            $servidor->update($validatedData);

            DB::commit();

            return redirect()
                ->route('servidores.show', $servidor->id)
                ->with('success', 'Servidor atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Erro ao atualizar servidor: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $servidor = Servidor::findOrFail($id);

            // Use soft delete (se estiver usando SoftDeletes)
            $servidor->delete();

            return redirect()->route('servidores.index')
                ->with('success', 'Servidor movido para a lixeira com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('servidores.index')
                ->with('error', 'Erro ao excluir servidor: ' . $e->getMessage());
        }
    }

    public function lixeira()
    {
        $servidores = Servidor::onlyTrashed()->with('perfil')->paginate(10);

        return view('servidor.colaboradores.delete', compact('servidores'));
    }

    /**
     * Restore a deleted server.
     */
    public function restore($id)
    {
        try {
            $servidor = Servidor::onlyTrashed()->findOrFail($id);
            $servidor->restore();

            return redirect()->route('servidores.lixeira')
                ->with('success', 'Servidor restaurado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('servidores.lixeira')
                ->with('error', 'Erro ao restaurar servidor: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete a server.
     */
    public function forceDelete($id)
    {
        try {
            $servidor = Servidor::onlyTrashed()->findOrFail($id);

            // Remove a foto se existir
            if ($servidor->foto) {
                Storage::disk('public')->delete($servidor->foto);
            }

            $servidor->forceDelete();

            return redirect()->route('servidores.lixeira')
                ->with('success', 'Servidor excluído permanentemente com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('servidores.lixeira')
                ->with('error', 'Erro ao excluir servidor: ' . $e->getMessage());
        }
    }

    /**
     * Empty the trash.
     */
    public function emptyTrash()
    {
        try {
            $servidores = Servidor::onlyTrashed()->get();

            foreach ($servidores as $servidor) {
                if ($servidor->foto) {
                    Storage::disk('public')->delete($servidor->foto);
                }
                $servidor->forceDelete();
            }

            return redirect()->route('servidores.lixeira')
                ->with('success', 'Lixeira esvaziada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('servidores.lixeira')
                ->with('error', 'Erro ao esvaziar lixeira: ' . $e->getMessage());
        }
    }
}
