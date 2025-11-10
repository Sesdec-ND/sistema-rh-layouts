<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use App\Models\Vinculo;
use App\Models\Lotacao;
use App\Models\Dependente;
use App\Models\Ocorrencia;
use App\Models\HistoricoPagamento;
use App\Models\Ferias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ServidorController extends Controller
{
    public function index()
    {
        // Redireciona para a página de colaboradores que já existe
        return redirect()->route('admin.colaborador');
    }

    public function create()
    {
        // Redireciona para a página de colaboradores que tem o modal de criação
        return redirect()->route('admin.colaborador');
    }

    public function store(Request $request)
    {
        try {
            // Verificar se há vínculos e lotações cadastrados
            $vinculosCount = Vinculo::count();
            $lotacoesCount = Lotacao::count();
            
            if ($vinculosCount === 0) {
                return redirect()->back()
                    ->with('error', 'Não é possível cadastrar servidor. Não há vínculos cadastrados. Por favor, execute o seeder: php artisan db:seed --class=VinculoSeeder')
                    ->withInput();
            }
            
            if ($lotacoesCount === 0) {
                return redirect()->back()
                    ->with('error', 'Não é possível cadastrar servidor. Não há lotações cadastradas. Por favor, execute o seeder: php artisan db:seed --class=LotacaoSeeder')
                    ->withInput();
            }
            
            // Log dos dados recebidos
            Log::info('Dados recebidos no store:', $request->all());
            
            // Verificar duplicações antes da validação para mensagens mais amigáveis
            $cpf = preg_replace('/[^0-9]/', '', $request->cpf ?? '');
            if (!empty($cpf) && Servidor::where('cpf', $cpf)->exists()) {
                return redirect()->back()
                    ->withErrors(['cpf' => 'Este CPF já está cadastrado no sistema. Por favor, verifique e tente novamente.'])
                    ->withInput();
            }
            
            if (!empty($request->email) && Servidor::where('email', $request->email)->exists()) {
                return redirect()->back()
                    ->withErrors(['email' => 'Este e-mail já está cadastrado no sistema. Por favor, verifique e tente novamente.'])
                    ->withInput();
            }
            
            if (!empty($request->matricula) && Servidor::where('matricula', $request->matricula)->exists()) {
                return redirect()->back()
                    ->withErrors(['matricula' => 'Esta matrícula já está cadastrada no sistema. Por favor, verifique e tente novamente.'])
                    ->withInput();
            }
            
        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:servidores,email',
            'matricula' => 'required|string|unique:servidores,matricula',
            'cpf' => 'required|string|max:14|unique:servidores,cpf',
            'rg' => 'nullable|string|max:50',
            'data_nascimento' => 'required|date',
            'genero' => 'nullable|in:Masculino,Feminino',
            'estado_civil' => 'nullable|in:Solteiro(a),Casado(a),Divorciado(a),Viúvo(a),União Estável',
            'formacao' => 'nullable|string|max:255',
            'status' => 'boolean',
            'data_nomeacao' => 'nullable|date',
            'telefone' => 'nullable|string|max:255',
            'endereco' => 'nullable|string',
            'raca_cor' => 'nullable|in:Branca,Preta,Parda,Amarela,Indígena',
            'tipo_sanguineo' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'pispasep' => 'nullable|string|max:20',
                'id_vinculo' => 'nullable|exists:vinculos,id_vinculo',
                'id_lotacao' => 'nullable|exists:lotacoes,id_lotacao',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

            Log::info('Dados validados:', $validated);

            // Upload da foto se existir
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('servidores/fotos', 'public');
                $validated['foto'] = $fotoPath;
            }

            // Garantir que status seja booleano (padrão true se não enviado)
            if (!isset($validated['status'])) {
                $validated['status'] = true;
            } else {
            $validated['status'] = $request->boolean('status');
            }

            // Limpar campos vazios e converter para null
            $fieldsToClean = ['id_vinculo', 'id_lotacao', 'rg', 'formacao', 'telefone', 'endereco', 'raca_cor', 'tipo_sanguineo', 'pispasep', 'data_nomeacao', 'estado_civil', 'genero'];
            foreach ($fieldsToClean as $field) {
                if (isset($validated[$field]) && ($validated[$field] === '' || $validated[$field] === null)) {
                    $validated[$field] = null;
                }
            }

            // Remover campos null de id_vinculo e id_lotacao se vazios
            if (empty($validated['id_vinculo']) || $validated['id_vinculo'] === '0') {
                unset($validated['id_vinculo']);
            }
            if (empty($validated['id_lotacao']) || $validated['id_lotacao'] === '0') {
                unset($validated['id_lotacao']);
            }

            Log::info('Dados antes de criar:', $validated);

            try {
            $servidor = Servidor::create($validated);
                Log::info('Servidor criado com sucesso:', ['matricula' => $servidor->matricula]);
                
                // Processar dependentes se existirem
                if ($request->has('dependentes') && is_array($request->dependentes)) {
                    foreach ($request->dependentes as $dependenteData) {
                        if (!empty($dependenteData['nome'])) {
                            Dependente::create([
                                'id_servidor' => $servidor->matricula,
                                'nome' => $dependenteData['nome'],
                                'parentesco' => $dependenteData['parentesco'] ?? null,
                                'data_nascimento' => $dependenteData['data_nascimento'] ?? null,
                                'cpf' => $dependenteData['cpf'] ?? null,
                                'genero' => $dependenteData['genero'] ?? null,
                            ]);
                        }
                    }
                    Log::info('Dependentes processados para servidor: ' . $servidor->matricula);
                }
                
                // Processar histórico de pagamentos se existirem
                if ($request->has('pagamentos') && is_array($request->pagamentos)) {
                    foreach ($request->pagamentos as $pagamentoData) {
                        if (!empty($pagamentoData['mes_ano'])) {
                            // Converter valor monetário
                            $valor = 0;
                            if (isset($pagamentoData['valor']) && !empty($pagamentoData['valor'])) {
                                $valorStr = str_replace(['R$', ' ', '.'], '', $pagamentoData['valor']);
                                $valorStr = str_replace(',', '.', $valorStr);
                                $valor = floatval($valorStr);
                            }
                            
                            // Converter mês/ano para data (formato YYYY-MM vira YYYY-MM-01)
                            $mesAno = $pagamentoData['mes_ano'];
                            if (strlen($mesAno) === 7) { // Formato YYYY-MM
                                $mesAno .= '-01';
                            }
                            
                            HistoricoPagamento::create([
                                'id_servidor' => $servidor->matricula,
                                'mes_ano' => $mesAno,
                                'valor' => $valor,
                                'status' => $pagamentoData['status'] ?? 'pendente',
                                'data_pagamento' => $pagamentoData['data_pagamento'] ?? null,
                                'observacoes' => $pagamentoData['observacoes'] ?? null,
                            ]);
                        }
                    }
                    Log::info('Pagamentos processados para servidor: ' . $servidor->matricula);
                }
                
                // Processar férias se existirem
                if ($request->has('ferias') && is_array($request->ferias)) {
                    foreach ($request->ferias as $feriasData) {
                        if (!empty($feriasData['data_inicio'])) {
                            Ferias::create([
                                'id_servidor' => $servidor->matricula,
                                'data_inicio' => $feriasData['data_inicio'],
                                'data_fim' => $feriasData['data_fim'] ?? null,
                                'dias' => $feriasData['dias'] ?? null,
                                'status' => $feriasData['status'] ?? 'Pendente',
                                'observacoes' => $feriasData['observacoes'] ?? null,
                            ]);
                        }
                    }
                    Log::info('Férias processadas para servidor: ' . $servidor->matricula);
                }
                
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error('Erro de banco de dados:', [
                    'message' => $e->getMessage(),
                    'sql' => $e->getSql() ?? 'N/A',
                    'bindings' => $e->getBindings() ?? []
                ]);
                
                // Verificar se é erro de duplicação
                $errorCode = $e->getCode();
                $errorMessage = $e->getMessage();
                
                // Erro 1062 = Duplicate entry
                if ($errorCode == 23000 || strpos($errorMessage, 'Duplicate entry') !== false) {
                    // Verificar qual campo está duplicado
                    if (strpos($errorMessage, 'servidores_cpf_unique') !== false || strpos($errorMessage, 'cpf') !== false) {
                        return redirect()->back()
                            ->withErrors(['cpf' => 'Este CPF já está cadastrado no sistema. Por favor, verifique e tente novamente.'])
                            ->withInput();
                    } elseif (strpos($errorMessage, 'servidores_email_unique') !== false || strpos($errorMessage, 'email') !== false) {
                        return redirect()->back()
                            ->withErrors(['email' => 'Este e-mail já está cadastrado no sistema. Por favor, verifique e tente novamente.'])
                            ->withInput();
                    } elseif (strpos($errorMessage, 'servidores_matricula_unique') !== false || strpos($errorMessage, 'matricula') !== false) {
                        return redirect()->back()
                            ->withErrors(['matricula' => 'Esta matrícula já está cadastrada no sistema. Por favor, verifique e tente novamente.'])
                            ->withInput();
                    }
                }
                
                throw new \Exception('Erro ao salvar no banco de dados: ' . $e->getMessage());
            }

            return redirect()->route('admin.colaborador')
                ->with('success', 'Servidor cadastrado com sucesso!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação:', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar servidor:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Erro ao cadastrar servidor: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            // Buscar servidor pela matrícula (chave primária)
            $servidor = Servidor::findOrFail($id);
            
            // Carregar relacionamentos principais
        $servidor->load(['vinculo', 'lotacao']);
            
            // Carregar relacionamentos opcionais e garantir que sejam Collections
            try {
                $servidor->load('dependentes');
                Log::info('Dependentes carregados para servidor ' . $id . ': ' . $servidor->dependentes->count());
            } catch (\Exception $e) {
                Log::warning('Erro ao carregar dependentes: ' . $e->getMessage());
                $servidor->setRelation('dependentes', collect());
            }
            
            try {
                $servidor->load('ocorrencias');
                Log::info('Ocorrencias carregadas para servidor ' . $id . ': ' . $servidor->ocorrencias->count());
            } catch (\Exception $e) {
                Log::warning('Erro ao carregar ocorrencias: ' . $e->getMessage());
                $servidor->setRelation('ocorrencias', collect());
            }
            
            try {
                $servidor->load('historicoPagamentos');
                Log::info('HistoricoPagamentos carregado para servidor ' . $id . ': ' . $servidor->historicoPagamentos->count());
                
                // Log detalhado dos pagamentos para debug
                foreach ($servidor->historicoPagamentos as $pagamento) {
                    Log::info('Pagamento carregado - ID: ' . $pagamento->id, [
                        'mes_ano' => $pagamento->mes_ano,
                        'valor' => $pagamento->valor,
                        'status' => $pagamento->status,
                        'data_pagamento' => $pagamento->data_pagamento,
                        'data_pagamento_attributes' => $pagamento->getAttributes()['data_pagamento'] ?? 'N/A',
                        'observacoes' => $pagamento->observacoes,
                        'observacoes_attributes' => $pagamento->getAttributes()['observacoes'] ?? 'N/A',
                    ]);
                }
            } catch (\Exception $e) {
                Log::warning('Erro ao carregar historicoPagamentos: ' . $e->getMessage());
                $servidor->setRelation('historicoPagamentos', collect());
            }
            
            try {
                $servidor->load('ferias');
                Log::info('Ferias carregadas para servidor ' . $id . ': ' . $servidor->ferias->count());
            } catch (\Exception $e) {
                Log::warning('Erro ao carregar ferias: ' . $e->getMessage());
                $servidor->setRelation('ferias', collect());
            }
            
            // Log detalhado para debug
            Log::info('Servidor carregado com sucesso:', [
                'matricula' => $servidor->matricula,
                'nome' => $servidor->nome_completo,
                'dependentes_count' => $servidor->dependentes->count(),
                'ocorrencias_count' => $servidor->ocorrencias->count(),
                'historicoPagamentos_count' => $servidor->historicoPagamentos->count(),
                'ferias_count' => $servidor->ferias->count(),
            ]);
            
            // Verificar se há dados diretamente do banco (debug)
            $dependentesDb = \App\Models\Dependente::where('id_servidor', $id)->count();
            $ocorrenciasDb = \App\Models\Ocorrencia::where('id_servidor', $id)->count();
            $pagamentosDb = \App\Models\HistoricoPagamento::where('id_servidor', $id)->count();
            $feriasDb = \App\Models\Ferias::where('id_servidor', $id)->count();
            
            Log::info('Dados diretamente do banco para servidor ' . $id . ':', [
                'dependentes_db' => $dependentesDb,
                'ocorrencias_db' => $ocorrenciasDb,
                'pagamentos_db' => $pagamentosDb,
                'ferias_db' => $feriasDb,
            ]);
            
            return view('servidor.colaboradores.show', compact('servidor'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Servidor não encontrado: ' . $id);
            return redirect()->route('admin.colaborador')
                ->with('error', 'Servidor não encontrado.');
        } catch (\Exception $e) {
            Log::error('Erro ao buscar servidor: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('admin.colaborador')
                ->with('error', 'Erro ao carregar dados do servidor: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            // Buscar servidor pela matrícula (chave primária) com todos os dados
            $servidor = Servidor::with([
                'vinculo', 
                'lotacao', 
                'dependentes', 
                'historicoPagamentos', 
                'ferias', 
                'ocorrencias'
            ])->findOrFail($id);
            
            // Carregar vínculos e lotações
        $vinculos = Vinculo::all();
        $lotacoes = Lotacao::where('status', true)->get();
            
            // Log para debug
            Log::info('Editando servidor:', [
                'matricula' => $servidor->matricula,
                'nome' => $servidor->nome_completo,
                'vinculo' => $servidor->id_vinculo,
                'lotacao' => $servidor->id_lotacao,
            ]);
            
            return view('servidor.colaboradores.edit', compact('servidor', 'vinculos', 'lotacoes'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar servidor para edição: ' . $e->getMessage());
            return redirect()->route('admin.colaborador')
                ->with('error', 'Erro ao carregar dados do servidor para edição.');
        }
    }

    public function update(Request $request, $id)
    {
        // Buscar servidor pela matrícula (chave primária)
        $servidor = Servidor::findOrFail($id);
        
        // Detectar se é uma atualização parcial (AJAX) ou completa
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';
        
        // Regras de validação base
        $rules = [];
        
        // Campos que podem ser atualizados
        // Se for AJAX, só valida campos presentes. Se não for AJAX, valida todos os obrigatórios
        if ($request->has('nome_completo')) {
            $rules['nome_completo'] = ($isAjax ? '' : 'required|') . 'string|max:255';
        } else if (!$isAjax) {
            $rules['nome_completo'] = 'required|string|max:255';
        }
        
        if ($request->has('email')) {
            $rules['email'] = ($isAjax ? '' : 'required|') . 'email|unique:servidores,email,' . $servidor->matricula . ',matricula';
        } else if (!$isAjax) {
            $rules['email'] = 'required|email|unique:servidores,email,' . $servidor->matricula . ',matricula';
        }
        
        if ($request->has('matricula')) {
            $rules['matricula'] = ($isAjax ? '' : 'required|') . 'string|unique:servidores,matricula,' . $servidor->matricula . ',matricula';
        } else if (!$isAjax) {
            $rules['matricula'] = 'required|string|unique:servidores,matricula,' . $servidor->matricula . ',matricula';
        }
        
        if ($request->has('cpf')) {
            $rules['cpf'] = ($isAjax ? '' : 'required|') . 'string|max:14|unique:servidores,cpf,' . $servidor->matricula . ',matricula';
        } else if (!$isAjax) {
            $rules['cpf'] = 'required|string|max:14|unique:servidores,cpf,' . $servidor->matricula . ',matricula';
        }
        if ($request->has('rg')) {
            $rules['rg'] = 'nullable|string|max:50';
        }
        if ($request->has('data_nascimento')) {
            $rules['data_nascimento'] = 'nullable|date';
        }
        if ($request->has('genero')) {
            $rules['genero'] = 'nullable|in:Masculino,Feminino';
        }
        if ($request->has('estado_civil')) {
            $rules['estado_civil'] = 'nullable|in:Solteiro(a),Casado(a),Divorciado(a),Viúvo(a),União Estável';
        }
        if ($request->has('formacao')) {
            $rules['formacao'] = 'nullable|string|max:255';
        }
        if ($request->has('status')) {
            $rules['status'] = 'boolean';
        }
        if ($request->has('data_nomeacao')) {
            $rules['data_nomeacao'] = 'nullable|date';
        }
        if ($request->has('telefone')) {
            $rules['telefone'] = 'nullable|string|max:255';
        }
        if ($request->has('endereco')) {
            $rules['endereco'] = 'nullable|string';
        }
        if ($request->has('raca_cor')) {
            $rules['raca_cor'] = 'nullable|in:Branca,Preta,Parda,Amarela,Indígena';
        }
        if ($request->has('tipo_sanguineo')) {
            $rules['tipo_sanguineo'] = 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-';
        }
        if ($request->has('pispasep')) {
            $rules['pispasep'] = 'nullable|string|max:20';
        }
        if ($request->has('id_vinculo')) {
            $rules['id_vinculo'] = 'nullable|exists:vinculos,id_vinculo';
        }
        if ($request->has('id_lotacao')) {
            $rules['id_lotacao'] = 'nullable|exists:lotacoes,id_lotacao';
        }
        if ($request->hasFile('foto')) {
            $rules['foto'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        try {
            // Verificar se precisa criar uma nova lotação
            if ($request->has('criar_lotacao') && $request->criar_lotacao == '1') {
                $lotacaoRules = [
                    'nome_lotacao' => 'required|string|max:255',
                    'sigla' => 'nullable|string|max:50',
                    'departamento' => 'nullable|string|max:255',
                    'localizacao' => 'nullable|string|max:255',
                    'status' => 'nullable|boolean',
                ];
                
                $lotacaoValidated = $request->validate($lotacaoRules);
                
                // Criar nova lotação
                $novaLotacao = Lotacao::create([
                    'nome_lotacao' => $lotacaoValidated['nome_lotacao'],
                    'sigla' => $lotacaoValidated['sigla'] ?? null,
                    'departamento' => $lotacaoValidated['departamento'] ?? null,
                    'localizacao' => $lotacaoValidated['localizacao'] ?? null,
                    'status' => $lotacaoValidated['status'] ?? true,
                ]);
                
                // Adicionar o id_lotacao ao request para atribuir ao servidor
                $request->merge(['id_lotacao' => $novaLotacao->id_lotacao]);
                
                // Adicionar a regra de validação para id_lotacao se não existir
                if (!isset($rules['id_lotacao'])) {
                    $rules['id_lotacao'] = 'nullable|exists:lotacoes,id_lotacao';
                }
            }
            
            // Validar apenas os campos presentes
            $validated = $request->validate($rules);

            // Upload da nova foto se existir
            if ($request->hasFile('foto')) {
                // Deletar foto antiga se existir
                if ($servidor->foto) {
                    Storage::disk('public')->delete($servidor->foto);
                }
                $fotoPath = $request->file('foto')->store('servidores/fotos', 'public');
                $validated['foto'] = $fotoPath;
            }

            // Garantir que status seja booleano se presente
            if (isset($validated['status'])) {
            $validated['status'] = $request->boolean('status');
            }

            // Limpar campos vazios e converter para null
            $fieldsToClean = ['id_vinculo', 'id_lotacao', 'rg', 'formacao', 'telefone', 'endereco', 'raca_cor', 'tipo_sanguineo', 'pispasep', 'data_nomeacao', 'estado_civil', 'genero', 'data_nascimento'];
            foreach ($fieldsToClean as $field) {
                if (isset($validated[$field]) && ($validated[$field] === '' || $validated[$field] === '0')) {
                    $validated[$field] = null;
                }
            }

            // Remover campos null de id_vinculo e id_lotacao se vazios
            if (isset($validated['id_vinculo']) && (empty($validated['id_vinculo']) || $validated['id_vinculo'] === '0')) {
                $validated['id_vinculo'] = null;
            }
            if (isset($validated['id_lotacao']) && (empty($validated['id_lotacao']) || $validated['id_lotacao'] === '0')) {
                $validated['id_lotacao'] = null;
            }

            $servidor->update($validated);

            // Recarregar o servidor para obter os dados atualizados
            $servidor->refresh();
            $servidor->load(['vinculo', 'lotacao']);

            // Se for requisição AJAX, retornar JSON
            if ($isAjax) {
                $response = [
                    'success' => true,
                    'message' => 'Dados atualizados com sucesso!',
                    'servidor' => $servidor->toArray(),
                ];

                // Adicionar URL da foto se foi atualizada ou se já existe
                if ($request->hasFile('foto') && $servidor->foto) {
                    $response['foto_url'] = asset('storage/' . $servidor->foto);
                } else if ($servidor->foto) {
                    // Se a foto já existe, retornar a URL também
                    $response['foto_url'] = asset('storage/' . $servidor->foto);
                }

                // Adicionar dados de lotação e vínculo se foram atualizados
                if (isset($validated['id_lotacao'])) {
                    if ($servidor->lotacao) {
                        $response['lotacao'] = $servidor->lotacao->toArray();
                    } else {
                        $response['lotacao'] = null;
                    }
                } else if ($servidor->lotacao) {
                    $response['lotacao'] = $servidor->lotacao->toArray();
                }

                if ($servidor->vinculo) {
                    $response['vinculo'] = $servidor->vinculo->toArray();
                } else if (isset($validated['id_vinculo']) && $validated['id_vinculo'] === null) {
                    $response['vinculo'] = null;
                }

                return response()->json($response);
            }

            // Redirecionar de volta para a página de edição (o método edit carregará os dados necessários)
            return redirect()->route('servidores.edit', $servidor->matricula)
                ->with('success', 'Servidor atualizado com sucesso!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Se for requisição AJAX, retornar erros de validação em JSON
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erros de validação',
                    'errors' => $e->errors()
                ], 422);
            }
            
            throw $e; // Relançar para Laravel tratar normalmente
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar servidor: ' . $e->getMessage(), [
                'servidor_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Se for requisição AJAX, retornar erro em JSON
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao atualizar servidor: ' . $e->getMessage()
                ], 500);
            }
            
            // Em caso de erro, voltar para a página de edição
            return redirect()->route('servidores.edit', $id)
                ->with('error', 'Erro ao atualizar servidor: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            // Buscar servidor pela matrícula (chave primária)
            $servidor = Servidor::findOrFail($id);
            
            // Deletar foto se existir
            if ($servidor->foto) {
                Storage::disk('public')->delete($servidor->foto);
            }

            $servidor->delete();

            return redirect()->route('admin.colaborador')
                ->with('success', 'Servidor excluído com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao excluir servidor: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            // Buscar servidor pela matrícula (chave primária)
            $servidor = Servidor::findOrFail($id);
            $servidor->update(['status' => !$servidor->status]);
            
            return redirect()->back()
                ->with('success', 'Status do servidor atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao alterar status: ' . $e->getMessage());
        }
    }
    
    // ========== MÉTODOS PARA GERENCIAR DEPENDENTES ==========
    public function storeDependente(Request $request, $servidorId)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'parentesco' => 'nullable|string|max:255',
            'data_nascimento' => 'nullable|date',
            'cpf' => 'nullable|string|max:14',
            'genero' => 'nullable|in:Masculino,Feminino',
        ]);
        
        $servidor = Servidor::findOrFail($servidorId);
        $validated['id_servidor'] = $servidor->matricula;
        
        Dependente::create($validated);
        
        // Se a requisição veio da página de edição, redirecionar para lá
        if ($request->has('from_edit') || strpos($request->header('Referer', ''), '/edit') !== false) {
            return redirect()->route('servidores.edit', $servidorId)
                ->with('success', 'Dependente cadastrado com sucesso!');
        }
        
        return redirect()->route('servidores.show', $servidorId)
            ->with('success', 'Dependente cadastrado com sucesso!');
    }
    
    public function updateDependente(Request $request, $servidorId, $dependenteId)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';
        
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'parentesco' => 'nullable|string|max:255',
            'data_nascimento' => 'nullable|date',
            'cpf' => 'nullable|string|max:14',
            'genero' => 'nullable|in:Masculino,Feminino',
        ]);
        
        $dependente = Dependente::findOrFail($dependenteId);
        $dependente->update($validated);
        
        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => 'Dependente atualizado com sucesso!',
                'dependente' => $dependente->fresh()
            ]);
        }
        
        return redirect()->route('servidores.edit', $servidorId)
            ->with('success', 'Dependente atualizado com sucesso!');
    }
    
    public function destroyDependente($servidorId, $dependenteId)
    {
        $dependente = Dependente::findOrFail($dependenteId);
        $dependente->delete();
        
        return redirect()->route('servidores.show', $servidorId)
            ->with('success', 'Dependente removido com sucesso!');
    }
    
    // ========== MÉTODOS PARA GERENCIAR OCORRÊNCIAS ==========
    public function storeOcorrencia(Request $request, $servidorId)
    {
        $validated = $request->validate([
            'tipo_ocorrencia' => 'required|string|max:255',
            'data_ocorrencia' => 'required|date',
            'descricao' => 'nullable|string',
            'status' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);
        
        $servidor = Servidor::findOrFail($servidorId);
        $validated['id_servidor'] = $servidor->matricula;
        
        Ocorrencia::create($validated);
        
        // Se a requisição veio da página de edição, redirecionar para lá
        if ($request->has('from_edit') || strpos($request->header('Referer', ''), '/edit') !== false) {
            return redirect()->route('servidores.edit', $servidorId)
                ->with('success', 'Ocorrência cadastrada com sucesso!');
        }
        
        return redirect()->route('servidores.show', $servidorId)
            ->with('success', 'Ocorrência cadastrada com sucesso!');
    }
    
    public function updateOcorrencia(Request $request, $servidorId, $ocorrenciaId)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';
        
        $validated = $request->validate([
            'tipo_ocorrencia' => 'required|string|max:255',
            'data_ocorrencia' => 'required|date',
            'descricao' => 'nullable|string',
            'status' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);
        
        $ocorrencia = Ocorrencia::findOrFail($ocorrenciaId);
        $ocorrencia->update($validated);
        
        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => 'Ocorrência atualizada com sucesso!',
                'ocorrencia' => $ocorrencia->fresh()
            ]);
        }
        
        return redirect()->route('servidores.edit', $servidorId)
            ->with('success', 'Ocorrência atualizada com sucesso!');
    }
    
    public function destroyOcorrencia($servidorId, $ocorrenciaId)
    {
        $ocorrencia = Ocorrencia::findOrFail($ocorrenciaId);
        $ocorrencia->delete();
        
        return redirect()->route('servidores.show', $servidorId)
            ->with('success', 'Ocorrência removida com sucesso!');
    }
    
    // ========== MÉTODOS PARA GERENCIAR PAGAMENTOS ==========
    public function storePagamento(Request $request, $servidorId)
    {
        $validated = $request->validate([
            'mes_ano' => 'required',
            'valor' => 'required|numeric',
            'status' => 'nullable|string|max:255',
            'data_pagamento' => 'nullable|date',
            'observacoes' => 'nullable|string',
        ]);
        
        $servidor = Servidor::findOrFail($servidorId);
        
        // Log dos dados recebidos ANTES da validação
        Log::info('Dados recebidos no storePagamento (request->all()):', $request->all());
        Log::info('Dados recebidos no storePagamento (request->input):', [
            'mes_ano' => $request->input('mes_ano'),
            'valor' => $request->input('valor'),
            'status' => $request->input('status'),
            'data_pagamento' => $request->input('data_pagamento'),
            'observacoes' => $request->input('observacoes'),
        ]);
        
        $validated['id_servidor'] = $servidor->matricula;
        
        // Converter mês/ano para data (formato YYYY-MM vira YYYY-MM-01)
        $mesAno = $validated['mes_ano'];
        if (strlen($mesAno) === 7) { // Formato YYYY-MM
            $mesAno .= '-01';
        }
        $validated['mes_ano'] = $mesAno;
        $validated['status'] = $validated['status'] ?? 'pendente';
        
        // Processar data_pagamento - garantir que seja incluído mesmo se vazio
        if ($request->has('data_pagamento') && !empty($request->input('data_pagamento'))) {
            $validated['data_pagamento'] = $request->input('data_pagamento');
        } else {
            $validated['data_pagamento'] = null;
        }
        
        // Processar observacoes - garantir que seja incluído mesmo se vazio
        if ($request->has('observacoes') && !empty(trim($request->input('observacoes')))) {
            $validated['observacoes'] = trim($request->input('observacoes'));
        } else {
            $validated['observacoes'] = null;
        }
        
        // Log para debug ANTES de criar
        Log::info('Dados validados antes de criar pagamento:', [
            'id_servidor' => $validated['id_servidor'],
            'mes_ano' => $validated['mes_ano'],
            'valor' => $validated['valor'],
            'status' => $validated['status'],
            'data_pagamento' => $validated['data_pagamento'] ?? 'NULL',
            'observacoes' => $validated['observacoes'] ?? 'NULL',
        ]);
        
        $pagamento = HistoricoPagamento::create($validated);
        
        // Recarregar o pagamento do banco para verificar se foi salvo corretamente
        $pagamento->refresh();
        
        // Log após criação - verificar dados salvos
        Log::info('Pagamento criado - Verificando dados salvos:', [
            'id' => $pagamento->id,
            'data_pagamento_eloquent' => $pagamento->data_pagamento ? $pagamento->data_pagamento->format('Y-m-d') : 'NULL',
            'data_pagamento_raw' => $pagamento->getAttributes()['data_pagamento'] ?? 'NULL',
            'observacoes_eloquent' => $pagamento->observacoes ?? 'NULL',
            'observacoes_raw' => $pagamento->getAttributes()['observacoes'] ?? 'NULL',
        ]);
        
        // Se a requisição veio da página de edição, redirecionar para lá
        if ($request->has('from_edit') || strpos($request->header('Referer', ''), '/edit') !== false) {
            return redirect()->route('servidores.edit', $servidorId)
                ->with('success', 'Pagamento cadastrado com sucesso!');
        }
        
        return redirect()->route('servidores.show', $servidorId)
            ->with('success', 'Pagamento cadastrado com sucesso!');
    }
    
    public function updatePagamento(Request $request, $servidorId, $pagamentoId)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';
        
        $validated = $request->validate([
            'mes_ano' => 'required',
            'valor' => 'required|numeric',
            'status' => 'nullable|string|max:255',
            'data_pagamento' => 'nullable|date',
            'observacoes' => 'nullable|string',
        ]);
        
        $pagamento = HistoricoPagamento::findOrFail($pagamentoId);
        
        // Converter mês/ano para data (formato YYYY-MM vira YYYY-MM-01)
        $mesAno = $validated['mes_ano'];
        if (strlen($mesAno) === 7) { // Formato YYYY-MM
            $mesAno .= '-01';
        }
        $validated['mes_ano'] = $mesAno;
        
        // Processar campos vazios
        if (empty($request->input('data_pagamento'))) {
            $validated['data_pagamento'] = null;
        }
        if (empty(trim($request->input('observacoes')))) {
            $validated['observacoes'] = null;
        }
        
        $pagamento->update($validated);
        
        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => 'Pagamento atualizado com sucesso!',
                'pagamento' => $pagamento->fresh()
            ]);
        }
        
        return redirect()->route('servidores.edit', $servidorId)
            ->with('success', 'Pagamento atualizado com sucesso!');
    }
    
    public function destroyPagamento($servidorId, $pagamentoId)
    {
        $pagamento = HistoricoPagamento::findOrFail($pagamentoId);
        $pagamento->delete();
        
        return redirect()->route('servidores.show', $servidorId)
            ->with('success', 'Pagamento removido com sucesso!');
    }
    
    // ========== MÉTODOS PARA GERENCIAR FÉRIAS ==========
    public function storeFeria(Request $request, $servidorId)
    {
        $validated = $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date',
            'dias' => 'nullable|integer',
            'status' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);
        
        $servidor = Servidor::findOrFail($servidorId);
        $validated['id_servidor'] = $servidor->matricula;
        
        Ferias::create($validated);
        
        // Se a requisição veio da página de edição, redirecionar para lá
        if ($request->has('from_edit') || strpos($request->header('Referer', ''), '/edit') !== false) {
            return redirect()->route('servidores.edit', $servidorId)
                ->with('success', 'Férias cadastradas com sucesso!');
        }
        
        return redirect()->route('servidores.show', $servidorId)
            ->with('success', 'Férias cadastradas com sucesso!');
    }
    
    public function updateFeria(Request $request, $servidorId, $feriaId)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';
        
        $validated = $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date',
            'dias' => 'nullable|integer',
            'status' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);
        
        $feria = Ferias::findOrFail($feriaId);
        $feria->update($validated);
        
        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => 'Férias atualizadas com sucesso!',
                'feria' => $feria->fresh()
            ]);
        }
        
        return redirect()->route('servidores.edit', $servidorId)
            ->with('success', 'Férias atualizadas com sucesso!');
    }
    
    public function destroyFeria($servidorId, $feriaId)
    {
        $feria = Ferias::findOrFail($feriaId);
        $feria->delete();
        
        return redirect()->route('servidores.show', $servidorId)
            ->with('success', 'Férias removidas com sucesso!');
    }
    
    // ========== MÉTODO PARA VISUALIZAÇÃO DE IMPRESSÃO/PDF ==========
    public function print($id)
    {
        try {
            // Buscar servidor pela matrícula (chave primária) com todos os relacionamentos
            $servidor = Servidor::with([
                'vinculo',
                'lotacao',
                'dependentes',
                'ocorrencias',
                'historicoPagamentos',
                'ferias',
                'user'
            ])->findOrFail($id);
            
            return view('servidor.colaboradores.print', compact('servidor'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Servidor não encontrado para impressão: ' . $id);
            return redirect()->route('admin.colaborador')
                ->with('error', 'Servidor não encontrado.');
        } catch (\Exception $e) {
            Log::error('Erro ao gerar visualização de impressão: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return redirect()->route('servidores.show', $id)
                ->with('error', 'Erro ao gerar visualização de impressão: ' . $e->getMessage());
        }
    }

    public function updateLotacao(Request $request, $id)
    {
        try {
            $lotacao = Lotacao::findOrFail($id);
            
            $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';
            
            $validated = $request->validate([
                'nome_lotacao' => 'required|string|max:255',
                'sigla' => 'nullable|string|max:50',
                'departamento' => 'nullable|string|max:255',
                'localizacao' => 'nullable|string|max:255',
                'status' => 'boolean',
            ]);
            
            // Garantir que status seja booleano
            if (isset($validated['status'])) {
                $validated['status'] = $request->boolean('status');
            }
            
            // Limpar campos vazios
            $fieldsToClean = ['sigla', 'departamento', 'localizacao'];
            foreach ($fieldsToClean as $field) {
                if (isset($validated[$field]) && ($validated[$field] === '')) {
                    $validated[$field] = null;
                }
            }
            
            $lotacao->update($validated);
            $lotacao->refresh();
            
            // Garantir que os dados relacionados também sejam atualizados
            $lotacao->load('servidores');
            
            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lotação atualizada com sucesso!',
                    'lotacao' => $lotacao->toArray(),
                ]);
            }
            
            return redirect()->back()
                ->with('success', 'Lotação atualizada com sucesso!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Erros de validação',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar lotação: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao atualizar lotação: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Erro ao atualizar lotação.');
        }
    }

    // ========== MÉTODOS DE LIXEIRA (SOFT DELETE) ==========
    
    /**
     * Lista servidores deletados (lixeira)
     */
    public function lixeira()
    {
        try {
            $servidores = Servidor::onlyTrashed()
                ->with(['vinculo', 'lotacao', 'user.perfil'])
                ->orderBy('deleted_at', 'desc')
                ->paginate(15);
            
            return view('servidor.colaboradores.lixeira', compact('servidores'));
        } catch (\Exception $e) {
            Log::error('Erro ao listar servidores da lixeira: ' . $e->getMessage());
            return redirect()->route('admin.colaborador')
                ->with('error', 'Erro ao carregar lixeira.');
        }
    }

    /**
     * Restaura um servidor deletado
     */
    public function restore($id)
    {
        try {
            $servidor = Servidor::onlyTrashed()->findOrFail($id);
            $servidor->restore();
            
            Log::info('Servidor restaurado: ' . $id);
            
            return redirect()->route('servidores.lixeira')
                ->with('success', 'Servidor restaurado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao restaurar servidor: ' . $e->getMessage());
            return redirect()->route('servidores.lixeira')
                ->with('error', 'Erro ao restaurar servidor: ' . $e->getMessage());
        }
    }

    /**
     * Remove permanentemente um servidor (force delete)
     */
    public function forceDelete($id)
    {
        try {
            $servidor = Servidor::onlyTrashed()->findOrFail($id);
            
            // Deletar foto se existir
            if ($servidor->foto) {
                Storage::disk('public')->delete($servidor->foto);
            }
            
            // Deletar relacionamentos
            $servidor->dependentes()->delete();
            $servidor->ocorrencias()->delete();
            $servidor->historicoPagamentos()->delete();
            $servidor->ferias()->delete();
            
            // Force delete do servidor
            $servidor->forceDelete();
            
            Log::info('Servidor removido permanentemente: ' . $id);
            
            return redirect()->route('servidores.lixeira')
                ->with('success', 'Servidor removido permanentemente!');
        } catch (\Exception $e) {
            Log::error('Erro ao remover servidor permanentemente: ' . $e->getMessage());
            return redirect()->route('servidores.lixeira')
                ->with('error', 'Erro ao remover servidor: ' . $e->getMessage());
        }
    }

    /**
     * Esvazia a lixeira (remove permanentemente todos os servidores deletados)
     */
    public function emptyTrash()
    {
        try {
            $servidores = Servidor::onlyTrashed()->get();
            $count = 0;
            
            foreach ($servidores as $servidor) {
                // Deletar foto se existir
                if ($servidor->foto) {
                    Storage::disk('public')->delete($servidor->foto);
                }
                
                // Deletar relacionamentos
                $servidor->dependentes()->delete();
                $servidor->ocorrencias()->delete();
                $servidor->historicoPagamentos()->delete();
                $servidor->ferias()->delete();
                
                // Force delete do servidor
                $servidor->forceDelete();
                $count++;
            }
            
            Log::info("Lixeira esvaziada. {$count} servidor(es) removido(s) permanentemente.");
            
            return redirect()->route('servidores.lixeira')
                ->with('success', "Lixeira esvaziada! {$count} servidor(es) removido(s) permanentemente.");
        } catch (\Exception $e) {
            Log::error('Erro ao esvaziar lixeira: ' . $e->getMessage());
            return redirect()->route('servidores.lixeira')
                ->with('error', 'Erro ao esvaziar lixeira: ' . $e->getMessage());
        }
    }
}