<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;
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
        // Se você quiser uma página separada para criar
        // return view('servidor.colaboradores.create');

        // Ou se está usando modal, redirecione para index
        // return redirect()->route('servidores.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Dados recebidos no request:', $request->all());

        $validated = $request->validate([
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
            'raca_cor' => 'nullable|string|max:50',
            'tipo_sanguineo' => 'nullable|string|max:5',
            'pispasep' => 'nullable|string|max:20', // CORRIGIDO: usar apenas pispasep
            'data_nomeacao' => 'nullable|date',
            'status' => 'required|boolean',
            'id_vinculo' => 'nullable|exists:vinculos,id',
            'id_lotacao' => 'nullable|exists:lotacoes,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();

        try {
            // 🔥 MAPEAMENTO CORRIGIDO - nomes dos campos devem bater com o banco
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
                'id_vinculo' => $validated['id_inculo'] ?? null,
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

            return redirect()->route('servidores.index')
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

        // 🔥 CORREÇÃO: Processar Ocorrências com campo 'tipo_ocorrencia'
        if ($request->has('ocorrencias')) {
            foreach ($request->ocorrencias as $ocorrenciaData) {
                if (!empty($ocorrenciaData['descricao'])) {
                    $servidor->ocorrencias()->create([
                        'tipo_ocorrencia' => $ocorrenciaData['tipo_ocorrencia'] ?? 'INREG', // ✅ CAMPO OBRIGATÓRIO
                        'descricao' => $ocorrenciaData['descricao'] ?? null,
                        'data_ocorrencia' => $ocorrenciaData['data_ocorrencia'] ?? now(),
                        'status' => $ocorrenciaData['status'] ?? 'Ativa',
                    ]);
                }
            }
        }

        // 🔥 NOVO: Processar Histórico de Pagamento
        if ($request->has('historicos_pagamento')) {
            foreach ($request->historicos_pagamento as $pagamentoData) {
                if (!empty($pagamentoData['mes_ano']) || !empty($pagamentoData['valor'])) {
                    $servidor->historicosPagamento()->create([
                        'mes_ano' => $pagamentoData['mes_ano'] ?? null,
                        'valor' => $pagamentoData['valor'] ?? 0,
                        'status' => $pagamentoData['status'] ?? 'Pendente',
                        'data_pagamento' => $pagamentoData['data_pagamento'] ?? null,
                    ]);
                }
            }
        }

        // 🔥 NOVO: Processar Férias
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

        // 🔥 NOVO: Processar Cursos
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

        // 🔥 NOVO: Processar Lotação (se for dinâmica)
        if ($request->has('lotacoes')) {
            foreach ($request->lotacoes as $lotacaoData) {
                if (!empty($lotacaoData['nomeLotacao']) || !empty($lotacaoData['departamento'])) {
                    // Aqui você pode criar uma nova lotação ou apenas registrar o histórico
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

        // 🔥 NOVO: Processar Vínculo (se for dinâmico)
        if ($request->has('vinculos')) {
            foreach ($request->vinculos as $vinculoData) {
                if (!empty($vinculoData['nomeVinculo']) || !empty($vinculoData['descricao'])) {
                    // Aqui você pode criar um novo vínculo ou apenas registrar o histórico
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
            'ocorrencias',
            'lotacao',
            'vinculo',
            'dependentes',
            'historicosPagamento',
            'ferias',
            'formacoes',
            'cursos'
        ])->findOrFail($id);

        return view('servidor.colaboradores.show', compact('servidor'));

        try {
            $servidor = Servidor::findOrFail($id);
            return view('servidor.colaboradores.show', compact('servidor'));
        } catch (\Exception $e) {
            return redirect()->route('servidores.index')
                ->with('error', 'Servidor não encontrado.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $servidor = Servidor::findOrFail($id);

            // Se você tiver lotações e vínculos
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
        try {
            $servidor = Servidor::findOrFail($id);

            $validated = $request->validate([
                'matricula' => 'required|string|max:20|unique:servidores,matricula,' . $id,
                'nome_completo' => 'required|string|max:255',
                'email' => 'required|email|unique:servidores,email,' . $id,
                'cpf' => 'required|string|max:14|unique:servidores,cpf,' . $id,
                'rg' => 'required|string|max:20',
                'data_nascimento' => 'required|date',
                'genero' => 'required|in:Masculino,Feminino',
                'estado_civil' => 'nullable|string|max:50',
                'telefone' => 'nullable|string|max:20',
                'endereco' => 'nullable|string|max:255',
                'tipo_sanguineo' => 'nullable|string|max:5',
                'pispasep' => 'nullable|string|max:20',
                'data_nomeacao' => 'nullable|date',
                'status' => 'required|boolean',
                'id_vinculo' => 'nullable|exists:vinculos,id',
                'id_lotacao' => 'nullable|exists:lotacoes,id',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            DB::beginTransaction();

            // Upload da nova foto se existir
            if ($request->hasFile('foto')) {
                // Deletar foto antiga se existir
                if ($servidor->foto && Storage::disk('public')->exists($servidor->foto)) {
                    Storage::disk('public')->delete($servidor->foto);
                }

                $fotoPath = $request->file('foto')->store('servidores/fotos', 'public');
                $validated['foto'] = $fotoPath;
            }

            $servidor->update($validated);

            DB::commit();

            return redirect()->route('servidores.index')
                ->with('success', 'Servidor atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Erro ao atualizar servidor: ' . $e->getMessage())
                ->withInput();
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
