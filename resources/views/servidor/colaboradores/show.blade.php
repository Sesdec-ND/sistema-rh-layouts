@extends('layouts.admin')

@section('title', 'Visualizar Servidor - RH')

@section('content')
    <div class="space-y-6">
        <!-- Mensagens de Sucesso/Erro -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Visualizar Servidor</h1>
                <p class="text-gray-600 mt-2">Detalhes completos do servidor</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('servidores.print', $servidor->matricula) }}" target="_blank"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-print mr-2"></i> Imprimir
                </a>
                <a href="{{ route('servidores.edit', $servidor->matricula) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
                <a href="{{ route('admin.colaborador') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Conteúdo Completo - TODAS AS INFORMAÇÕES EM UMA TELA -->
            <div class="p-6 space-y-8">

                <!-- Seção: Dados do Servidor -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-blue-500 pb-3 mb-6">
                        <i class="fas fa-user mr-2"></i>Dados do Servidor
                    </h2>
                    
                    <!-- Foto no Topo -->
                    <div class="flex flex-col items-center mb-8">
                        <div
                            class="w-48 h-48 bg-gray-200 rounded-full mb-4 flex items-center justify-center overflow-hidden border-4 border-white shadow-lg">
                            @if ($servidor->foto)
                                <img src="{{ Storage::url($servidor->foto) }}" alt="{{ $servidor->nome_completo }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">
                                    <i class="fas fa-user text-4xl"></i>
                                </div>
                            @endif
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 text-center">{{ $servidor->nome_completo }}</h2>
                        <p class="text-gray-600 text-center mt-2">{{ $servidor->matricula }}</p>
                        <div class="mt-4">
                            @if ($servidor->status)
                                <span
                                    class="px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">Ativo</span>
                            @else
                                <span
                                    class="px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">Inativo</span>
                            @endif
                        </div>
                    </div>

                    <!-- Dados Pessoais e Profissionais -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Dados Pessoais</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Matrícula</label>
                            <p class="text-gray-900 font-semibold">{{ $servidor->matricula }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                            <p class="text-gray-900">{{ $servidor->cpf }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">RG</label>
                            <p class="text-gray-900">{{ $servidor->rg ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Data Nascimento</label>
                            <p class="text-gray-900">
                                @if($servidor->data_nascimento)
                                    {{ \Carbon\Carbon::parse($servidor->data_nascimento)->format('d/m/Y') }}
                                    ({{ $servidor->calcularIdade() }} anos)
                                @else
                                    Não informado
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gênero</label>
                            <p class="text-gray-900">{{ $servidor->genero ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado Civil</label>
                            <p class="text-gray-900">{{ $servidor->estado_civil ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                            <p class="text-gray-900">{{ $servidor->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                            <p class="text-gray-900">{{ $servidor->telefone ?? 'Não informado' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                            <p class="text-gray-900">{{ $servidor->endereco ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Raça/Cor</label>
                            <p class="text-gray-900">{{ $servidor->raca_cor ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Sanguíneo</label>
                            <p class="text-gray-900">{{ $servidor->tipo_sanguineo ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">PIS/PASEP</label>
                            <p class="text-gray-900">{{ $servidor->pispasep ?? 'Não informado' }}</p>
                        </div>

                        <div class="md:col-span-2 mt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Dados Profissionais</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Data Nomeação</label>
                            <p class="text-gray-900">
                                {{ $servidor->data_nomeacao ? \Carbon\Carbon::parse($servidor->data_nomeacao)->format('d/m/Y') : 'Não informado' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Formação</label>
                            <p class="text-gray-900">{{ $servidor->formacao ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <p class="text-gray-900">
                                @if ($servidor->status)
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Ativo</span>
                                @else
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Inativo</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Seção: Lotação -->
                <div class="pt-8 border-t border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-blue-500 pb-3 mb-6">
                        <i class="fas fa-building mr-2"></i>Dados de Lotação
                    </h2>
                    @if ($servidor->lotacao)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nome da Lotação</label>
                                <p class="text-gray-900 font-semibold">{{ $servidor->lotacao->nome_lotacao }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sigla</label>
                                <p class="text-gray-900">{{ $servidor->lotacao->sigla ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                                <p class="text-gray-900">{{ $servidor->lotacao->departamento ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Localização</label>
                                <p class="text-gray-900">{{ $servidor->lotacao->localizacao ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <p class="text-gray-900">
                                    @if ($servidor->lotacao->status)
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Ativa</span>
                                    @else
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Inativa</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-building text-3xl mb-3"></i>
                            <p>Nenhuma lotação registrada</p>
                        </div>
                    @endif
                </div>

                <!-- Seção: Vínculo -->
                <div class="pt-8 border-t border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-blue-500 pb-3 mb-6">
                        <i class="fas fa-link mr-2"></i>Dados de Vínculo
                    </h2>
                    @if ($servidor->vinculo)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nome do Vínculo</label>
                                <p class="text-gray-900 font-semibold">{{ $servidor->vinculo->nome_vinculo }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                                <p class="text-gray-900">{{ $servidor->vinculo->descricao ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Data de Criação</label>
                                <p class="text-gray-900">
                                    {{ \Carbon\Carbon::parse($servidor->vinculo->created_at)->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-link text-3xl mb-3"></i>
                            <p>Nenhum vínculo registrado</p>
                        </div>
                    @endif
                </div>

                <!-- Seção: Dependentes -->
                <div class="pt-8 border-t border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-blue-500 pb-3">
                            <i class="fas fa-users mr-2"></i>Dependentes
                        </h2>
                        <!-- <button type="button" onclick="abrirModalDependente()"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                            <i class="fas fa-plus mr-2"></i> Adicionar Dependente
                        </button> -->
                    </div>
                    @php
                        $dependentes = $servidor->dependentes ?? collect();
                    @endphp
                    @if ($dependentes->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($dependentes as $dependente)
                                <div class="rounded-lg p-4 bg-white">
                                    <div class="flex justify-between items-start mb-3">
                                        <h4 class="font-semibold text-gray-800">{{ $dependente->nome }}</h4>
                                    </div>
                                    <div class="space-y-2">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600">Parentesco</label>
                                            <p class="text-gray-900">{{ $dependente->parentesco ?? 'Não informado' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600">Data Nascimento</label>
                                            <p class="text-gray-900">
                                                {{ $dependente->data_nascimento ? \Carbon\Carbon::parse($dependente->data_nascimento)->format('d/m/Y') : 'Não informado' }}
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600">CPF</label>
                                            <p class="text-gray-900">{{ $dependente->cpf ?? 'Não informado' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600">Gênero</label>
                                            <p class="text-gray-900">{{ $dependente->genero ?? 'Não informado' }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <form action="{{ route('servidores.dependentes.destroy', [$servidor->matricula, $dependente->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este dependente?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                <i class="fas fa-trash mr-1"></i> Remover
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-users text-3xl mb-3"></i>
                            <p>Nenhum dependente registrado</p>
                        </div>
                    @endif
                </div>

                <!-- Seção: Pagamentos -->
                <div class="pt-8 border-t border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-blue-500 pb-3">
                            <i class="fas fa-money-bill-wave mr-2"></i>Histórico de Pagamento
                        </h2>
                        <button type="button" onclick="abrirModalPagamento()"
                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition duration-200 flex items-center justify-center" title="Adicionar Pagamento">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    @php
                        $historicoPagamentos = $servidor->historicoPagamentos ?? collect();
                    @endphp
                    @if ($historicoPagamentos->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Competência</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Pagamento</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observações</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($historicoPagamentos as $pagamento)
                                        @php
                                            // Obter valores diretamente dos atributos do modelo para evitar problemas com casts
                                            $dataPagamentoRaw = $pagamento->getAttributes()['data_pagamento'] ?? null;
                                            $observacoesRaw = $pagamento->getAttributes()['observacoes'] ?? null;
                                            
                                            // Formatar data de pagamento se existir
                                            $dataPagamentoFormatada = null;
                                            if ($dataPagamentoRaw) {
                                                try {
                                                    $dataPagamentoFormatada = \Carbon\Carbon::parse($dataPagamentoRaw)->format('d/m/Y');
                                                } catch (\Exception $e) {
                                                    $dataPagamentoFormatada = $dataPagamentoRaw;
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $pagamento->competencia ?? ($pagamento->mes_ano ? $pagamento->mes_ano->format('m/Y') : 'N/A') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $pagamento->valor_formatado ?? 'R$ ' . number_format($pagamento->valor ?? 0, 2, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $pagamento->status ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($dataPagamentoFormatada)
                                                    {{ $dataPagamentoFormatada }}
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                @if($observacoesRaw && trim($observacoesRaw) !== '')
                                                    {{ $observacoesRaw }}
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <form action="{{ route('servidores.pagamentos.destroy', [$servidor->matricula, $pagamento->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este pagamento?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-money-bill-wave text-3xl mb-3"></i>
                            <p>Nenhum pagamento registrado</p>
                        </div>
                    @endif
                </div>

                <!-- Seção: Férias -->
                <div class="pt-8 border-t border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-blue-500 pb-3">
                            <i class="fas fa-umbrella-beach mr-2"></i>Histórico de Férias
                        </h2>
                        <button type="button" onclick="abrirModalFeria()"
                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition duration-200 flex items-center justify-center" title="Adicionar Férias">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    @php
                        $ferias = $servidor->ferias ?? collect();
                    @endphp
                    @if ($ferias->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($ferias as $feria)
                                <div class="rounded-lg p-4 bg-white">
                                    <div class="flex justify-between items-start mb-3">
                                        <h4 class="font-semibold text-gray-800">Período {{ $loop->iteration }}</h4>
                                        <span class="px-2 py-1 rounded text-xs font-semibold 
                                            {{ $feria->status == 'Aprovado' ? 'bg-green-100 text-green-800' : 
                                               ($feria->status == 'Pendente' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-red-100 text-red-800') }}">
                                            {{ $feria->status ?? 'Pendente' }}
                                        </span>
                                    </div>
                                    <div class="space-y-2">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600">Dias</label>
                                            <p class="text-gray-900">
                                                {{ $feria->dias ?? 'Não informado' }}
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600">Data Início</label>
                                            <p class="text-gray-900">
                                                {{ $feria->data_inicio ? $feria->data_inicio->format('d/m/Y') : 'Não informado' }}
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600">Data Fim</label>
                                            <p class="text-gray-900">
                                                {{ $feria->data_fim ? $feria->data_fim->format('d/m/Y') : 'Não informado' }}
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600">Status</label>
                                            <p class="text-gray-900">
                                                {{ $feria->status ?? 'Não informado' }}
                                            </p>
                                        </div>
                                        @if($feria->observacoes)
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600">Observações</label>
                                                <p class="text-gray-900 text-sm">{{ $feria->observacoes }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <form action="{{ route('servidores.ferias.destroy', [$servidor->matricula, $feria->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este período de férias?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                <i class="fas fa-trash mr-1"></i> Remover
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-umbrella-beach text-3xl mb-3"></i>
                            <p>Nenhum período de férias registrado</p>
                        </div>
                    @endif
                </div>

                <!-- Seção: Ocorrências -->
                <div class="pt-8 border-t border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-blue-500 pb-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Ocorrências
                        </h2>
                        <button type="button" onclick="abrirModalOcorrencia()"
                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition duration-200 flex items-center justify-center" title="Adicionar Ocorrência">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    @php
                        $ocorrencias = $servidor->ocorrencias ?? collect();
                    @endphp
                    @if ($ocorrencias->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Ocorrência</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observações</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($ocorrencias as $ocorrencia)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $ocorrencia->tipo_ocorrencia }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $ocorrencia->data_ocorrencia ? $ocorrencia->data_ocorrencia->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $ocorrencia->status ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $ocorrencia->descricao ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $ocorrencia->observacoes ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <form action="{{ route('servidores.ocorrencias.destroy', [$servidor->matricula, $ocorrencia->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover esta ocorrência?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-exclamation-triangle text-3xl mb-3"></i>
                            <p>Nenhuma ocorrência registrada</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Funções para abrir e fechar modais
        function abrirModalDependente() {
            document.getElementById('modalDependente').classList.remove('hidden');
        }
        
        function fecharModalDependente() {
            document.getElementById('modalDependente').classList.add('hidden');
            document.getElementById('formDependente').reset();
        }
        
        function abrirModalOcorrencia() {
            document.getElementById('modalOcorrencia').classList.remove('hidden');
        }
        
        function fecharModalOcorrencia() {
            document.getElementById('modalOcorrencia').classList.add('hidden');
            document.getElementById('formOcorrencia').reset();
        }
        
        function abrirModalPagamento() {
            document.getElementById('modalPagamento').classList.remove('hidden');
        }
        
        function fecharModalPagamento() {
            document.getElementById('modalPagamento').classList.add('hidden');
            document.getElementById('formPagamento').reset();
        }
        
        function abrirModalFeria() {
            document.getElementById('modalFeria').classList.remove('hidden');
        }
        
        function fecharModalFeria() {
            document.getElementById('modalFeria').classList.add('hidden');
            document.getElementById('formFeria').reset();
        }
    </script>
@endpush

<!-- Modal para Adicionar Dependente -->
<div id="modalDependente" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Adicionar Dependente</h3>
            <button onclick="fecharModalDependente()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formDependente" action="{{ route('servidores.dependentes.store', $servidor->matricula) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                    <input type="text" name="nome" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Parentesco</label>
                    <select name="parentesco" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Selecione</option>
                        <option value="Filho(a)">Filho(a)</option>
                        <option value="Cônjuge">Cônjuge</option>
                        <option value="Pai/Mãe">Pai/Mãe</option>
                        <option value="Outros">Outros</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Nascimento</label>
                    <input type="date" name="data_nascimento" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                    <input type="text" name="cpf" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gênero</label>
                    <select name="genero" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Selecione</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalDependente()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Adicionar Ocorrência -->
<div id="modalOcorrencia" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Adicionar Ocorrência</h3>
            <button onclick="fecharModalOcorrencia()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formOcorrencia" action="{{ route('servidores.ocorrencias.store', $servidor->matricula) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Ocorrência *</label>
                    <input type="text" name="tipo_ocorrencia" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ex: Advertência, Elogio, etc.">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data da Ocorrência *</label>
                    <input type="date" name="data_ocorrencia" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                    <textarea name="descricao" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="pendente">Pendente</option>
                        <option value="resolvida">Resolvida</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                    <textarea name="observacoes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalOcorrencia()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Adicionar Pagamento -->
<div id="modalPagamento" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Adicionar Pagamento</h3>
            <button onclick="fecharModalPagamento()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formPagamento" action="{{ route('servidores.pagamentos.store', $servidor->matricula) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mês/Ano (Competência) *</label>
                    <input type="month" name="mes_ano" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Valor *</label>
                    <input type="number" name="valor" step="0.01" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="0.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="pendente">Pendente</option>
                        <option value="pago">Pago</option>
                        <option value="atrasado">Atrasado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data do Pagamento</label>
                    <input type="date" name="data_pagamento" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                    <textarea name="observacoes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalPagamento()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Adicionar Férias -->
<div id="modalFeria" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Adicionar Férias</h3>
            <button onclick="fecharModalFeria()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formFeria" action="{{ route('servidores.ferias.store', $servidor->matricula) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Início *</label>
                    <input type="date" name="data_inicio" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Fim</label>
                    <input type="date" name="data_fim" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dias</label>
                    <input type="number" name="dias" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="Pendente">Pendente</option>
                        <option value="Aprovado">Aprovado</option>
                        <option value="Rejeitado">Rejeitado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                    <textarea name="observacoes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalFeria()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>