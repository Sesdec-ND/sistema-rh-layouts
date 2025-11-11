@extends('layouts.admin')

@section('title', 'Editar Servidor')


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
                <strong class="font-bold">Erros de validação:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Editar Servidor</h1>
                <p class="text-gray-600 mt-2">Atualize as informações do servidor: <strong>{{ $servidor->nome_completo }}</strong></p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('servidores.show', $servidor->id) }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-eye mr-2"></i> Visualizar
                </a>
                <a href="{{ route('servidores.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar
                </a>
            </div>
        </div>

        <!-- Formulário Completo - TODOS OS CAMPOS EM UMA TELA -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <form id="mainForm" action="{{ route('servidores.update', $servidor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="servidor_id" value="{{ $servidor->id }}">

                <!-- Seção: Foto -->
                <div class="mb-8 pb-8 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-blue-500 pb-3">
                            <i class="fas fa-image mr-2"></i>Foto do Servidor
                        </h2>
                        <button type="button" onclick="abrirModalEditarFoto()" 
                            class="text-blue-600 hover:text-blue-800" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    
                    <!-- Foto no Topo -->
                    <div class="flex flex-col items-center">
                        <div id="previewFoto"
                            class="w-48 h-48 bg-gray-200 rounded-full mb-4 flex items-center justify-center overflow-hidden border-4 border-white shadow-lg">
                                @if ($servidor->foto)
                                <img src="{{ asset('storage/' . $servidor->foto) }}?v={{ time() }}" alt="{{ $servidor->nome ?? $servidor->nome_completo }}"
                                    class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">
                                    <i class="fas fa-user text-4xl"></i>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>

                <!-- Seção: Dados Pessoais -->
                <div class="mb-8 pb-8 border-b border-gray-200" id="secao-dados-pessoais">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-blue-500 pb-3">
                            <i class="fas fa-user mr-2"></i>Dados Pessoais
                        </h2>
                        <button type="button" onclick="salvarSecao('dados-pessoais')" 
                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition duration-200 flex items-center justify-center" title="Salvar Dados Pessoais">
                            <i class="fas fa-save"></i>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Nome Completo -->
                        <div class="md:col-span-2">
                            <label for="nome_completo" class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo *</label>
                            <input type="text" id="nome_completo" name="nome_completo"
                                value="{{ old('nome_completo', $servidor->nome_completo) }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nome_completo') border-red-500 @enderror">
                            @error('nome_completo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Matrícula -->
                        <div>
                            <label for="matricula" class="block text-sm font-semibold text-gray-700 mb-2">Matrícula *</label>
                            <input type="text" id="matricula" name="matricula"
                                value="{{ old('matricula', $servidor->matricula) }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('matricula') border-red-500 @enderror">
                            @error('matricula')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- CPF -->
                        <div>
                            <label for="cpf" class="block text-sm font-semibold text-gray-700 mb-2">CPF *</label>
                            <input type="text" id="cpf" name="cpf" 
                                value="{{ old('cpf', $servidor->cpf) }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 cpf @error('cpf') border-red-500 @enderror">
                            @error('cpf')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- RG -->
                        <div>
                            <label for="rg" class="block text-sm font-semibold text-gray-700 mb-2">RG</label>
                            <input type="text" id="rg" name="rg" 
                                value="{{ old('rg', $servidor->rg) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('rg') border-red-500 @enderror">
                            @error('rg')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Data Nascimento -->
                        <div>
                            <label for="data_nascimento" class="block text-sm font-semibold text-gray-700 mb-2">Data Nascimento</label>
                            <input type="date" id="data_nascimento" name="data_nascimento"
                                value="{{ old('data_nascimento', $servidor->data_nascimento ? (\Carbon\Carbon::parse($servidor->data_nascimento)->format('Y-m-d')) : '') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('data_nascimento') border-red-500 @enderror">
                            @error('data_nascimento')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gênero -->
                        <div>
                            <label for="genero" class="block text-sm font-semibold text-gray-700 mb-2">Gênero</label>
                            <select id="genero" name="genero"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('genero') border-red-500 @enderror">
                                <option value="">Selecione...</option>
                                <option value="Masculino" @if (old('genero', $servidor->genero) == 'Masculino') selected @endif>Masculino</option>
                                <option value="Feminino" @if (old('genero', $servidor->genero) == 'Feminino') selected @endif>Feminino</option>
                            </select>
                            @error('genero')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado Civil -->
                        <div>
                            <label for="estado_civil" class="block text-sm font-semibold text-gray-700 mb-2">Estado Civil</label>
                            <select id="estado_civil" name="estado_civil"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('estado_civil') border-red-500 @enderror">
                                <option value="">Selecione...</option>
                                <option value="Solteiro(a)" @if (old('estado_civil', $servidor->estado_civil) == 'Solteiro(a)') selected @endif>Solteiro(a)</option>
                                <option value="Casado(a)" @if (old('estado_civil', $servidor->estado_civil) == 'Casado(a)') selected @endif>Casado(a)</option>
                                <option value="Divorciado(a)" @if (old('estado_civil', $servidor->estado_civil) == 'Divorciado(a)') selected @endif>Divorciado(a)</option>
                                <option value="Viúvo(a)" @if (old('estado_civil', $servidor->estado_civil) == 'Viúvo(a)') selected @endif>Viúvo(a)</option>
                                <option value="União Estável" @if (old('estado_civil', $servidor->estado_civil) == 'União Estável') selected @endif>União Estável</option>
                            </select>
                            @error('estado_civil')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" id="email" name="email" 
                                value="{{ old('email', $servidor->email) }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Telefone -->
                        <div>
                            <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-2">Telefone</label>
                            <input type="text" id="telefone" name="telefone"
                                value="{{ old('telefone', $servidor->telefone) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 telefone @error('telefone') border-red-500 @enderror">
                            @error('telefone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Endereço -->
                        <div class="md:col-span-2">
                            <label for="endereco" class="block text-sm font-semibold text-gray-700 mb-2">Endereço</label>
                            <textarea id="endereco" name="endereco" rows="3"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('endereco') border-red-500 @enderror">{{ old('endereco', $servidor->endereco) }}</textarea>
                            @error('endereco')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Raça/Cor -->
                        <div>
                            <label for="raca_cor" class="block text-sm font-semibold text-gray-700 mb-2">Raça/Cor</label>
                            <select id="raca_cor" name="raca_cor"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('raca_cor') border-red-500 @enderror">
                                <option value="">Selecione...</option>
                                <option value="Branca" @if (old('raca_cor', $servidor->raca_cor) == 'Branca') selected @endif>Branca</option>
                                <option value="Preta" @if (old('raca_cor', $servidor->raca_cor) == 'Preta') selected @endif>Preta</option>
                                <option value="Parda" @if (old('raca_cor', $servidor->raca_cor) == 'Parda') selected @endif>Parda</option>
                                <option value="Amarela" @if (old('raca_cor', $servidor->raca_cor) == 'Amarela') selected @endif>Amarela</option>
                                <option value="Indígena" @if (old('raca_cor', $servidor->raca_cor) == 'Indígena') selected @endif>Indígena</option>
                            </select>
                            @error('raca_cor')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo Sanguíneo -->
                        <div>
                            <label for="tipo_sanguineo" class="block text-sm font-semibold text-gray-700 mb-2">Tipo Sanguíneo</label>
                            <select id="tipo_sanguineo" name="tipo_sanguineo"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tipo_sanguineo') border-red-500 @enderror">
                                <option value="">Selecione...</option>
                                <option value="A+" @if (old('tipo_sanguineo', $servidor->tipo_sanguineo) == 'A+') selected @endif>A+</option>
                                <option value="A-" @if (old('tipo_sanguineo', $servidor->tipo_sanguineo) == 'A-') selected @endif>A-</option>
                                <option value="B+" @if (old('tipo_sanguineo', $servidor->tipo_sanguineo) == 'B+') selected @endif>B+</option>
                                <option value="B-" @if (old('tipo_sanguineo', $servidor->tipo_sanguineo) == 'B-') selected @endif>B-</option>
                                <option value="AB+" @if (old('tipo_sanguineo', $servidor->tipo_sanguineo) == 'AB+') selected @endif>AB+</option>
                                <option value="AB-" @if (old('tipo_sanguineo', $servidor->tipo_sanguineo) == 'AB-') selected @endif>AB-</option>
                                <option value="O+" @if (old('tipo_sanguineo', $servidor->tipo_sanguineo) == 'O+') selected @endif>O+</option>
                                <option value="O-" @if (old('tipo_sanguineo', $servidor->tipo_sanguineo) == 'O-') selected @endif>O-</option>
                            </select>
                            @error('tipo_sanguineo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- PIS/PASEP -->
                        <div>
                            <label for="pispasep" class="block text-sm font-semibold text-gray-700 mb-2">PIS/PASEP</label>
                            <input type="text" id="pispasep" name="pispasep"
                                value="{{ old('pispasep', $servidor->pispasep) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pispasep') border-red-500 @enderror">
                            @error('pispasep')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div id="mensagem-dados-pessoais" class="mt-4"></div>
                </div>

                <!-- Seção: Dados Profissionais -->
                <div class="mb-8 pb-8 border-b border-gray-200" id="secao-dados-profissionais">
                    <div class="mb-6">
                        <div class="flex items-center gap-2 border-b-2 border-blue-500 pb-3">
                            <h2 class="text-2xl font-bold text-gray-800">
                                <i class="fas fa-briefcase mr-2"></i>Dados Profissionais
                            </h2>
                            <button type="button" onclick="abrirModalEditarDadosProfissionais()" 
                                class="text-blue-600 hover:text-blue-800" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Informações dos Dados Profissionais (somente leitura) -->
                    <div id="dados-profissionais-info-container">
                        @if ($servidor->data_nomeacao || $servidor->formacao || isset($servidor->status))
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Dados Profissionais Atuais</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Data Nomeação</label>
                                        <p class="text-gray-900" data-dados-profissionais-data-nomeacao>
                                            {{ $servidor->data_nomeacao ? \Carbon\Carbon::parse($servidor->data_nomeacao)->format('d/m/Y') : 'Não informado' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Formação</label>
                                        <p class="text-gray-900" data-dados-profissionais-formacao>{{ $servidor->formacao ?? 'Não informado' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                                        <p class="text-gray-900" data-dados-profissionais-status>
                                            @if (isset($servidor->status))
                                                @if ($servidor->status)
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Ativo</span>
                                                @else
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Inativo</span>
                                                @endif
                                            @else
                                                Não informado
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                <p class="text-sm text-yellow-800">Nenhum dado profissional informado no momento.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Seção: Lotação -->
                <div class="mb-8 pb-8 border-b border-gray-200" id="secao-lotacao">
                    <div class="mb-6">
                        <div class="flex items-center gap-2 border-b-2 border-blue-500 pb-3">
                            <h2 class="text-2xl font-bold text-gray-800">
                                <i class="fas fa-building mr-2"></i>Dados de Lotação
                            </h2>
                            @if ($servidor->lotacao)
                            <button type="button" onclick="abrirModalEditarLotacao({{ $servidor->lotacao->id_lotacao }}, '{{ addslashes($servidor->lotacao->nome_lotacao) }}', '{{ addslashes($servidor->lotacao->sigla ?? '') }}', '{{ addslashes($servidor->lotacao->departamento ?? '') }}', '{{ addslashes($servidor->lotacao->localizacao ?? '') }}', {{ $servidor->lotacao->status ? 1 : 0 }})" 
                                class="text-blue-600 hover:text-blue-800" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            @else
                            <button type="button" onclick="abrirModalAtribuirLotacao()" 
                                class="text-blue-600 hover:text-blue-800" title="Atribuir Lotação">
                                <i class="fas fa-edit"></i>
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Informações da Lotação Atual (somente leitura) -->
                    <div id="lotacao-info-container">
                        @if ($servidor->lotacao)
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Lotação Atual</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Nome da Lotação</label>
                                        <p class="text-gray-900 font-semibold" data-lotacao-nome>{{ $servidor->lotacao->nome_lotacao }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Sigla</label>
                                        <p class="text-gray-900" data-lotacao-sigla>{{ $servidor->lotacao->sigla ?? 'Não informado' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Departamento</label>
                                        <p class="text-gray-900" data-lotacao-departamento>{{ $servidor->lotacao->departamento ?? 'Não informado' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Localização</label>
                                        <p class="text-gray-900" data-lotacao-localizacao>{{ $servidor->lotacao->localizacao ?? 'Não informado' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                                        <p class="text-gray-900" data-lotacao-status>
                                            @if ($servidor->lotacao->status)
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Ativa</span>
                                            @else
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Inativa</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                <p class="text-sm text-yellow-800">Nenhuma lotação atribuída no momento.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Seção: Vínculo -->
                <div class="mb-8" id="secao-vinculo">
                    <div class="mb-6">
                        <div class="flex items-center gap-2 border-b-2 border-blue-500 pb-3">
                            <h2 class="text-2xl font-bold text-gray-800">
                                <i class="fas fa-link mr-2"></i>Dados de Vínculo
                            </h2>
                            <button type="button" onclick="abrirModalEditarVinculo()" 
                                class="text-blue-600 hover:text-blue-800" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Informações do Vínculo Atual (somente leitura) -->
                    <div id="vinculo-info-container">
                        @if ($servidor->vinculo)
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Vínculo Atual</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Vínculo</label>
                                        <p class="text-gray-900 font-semibold" data-vinculo-nome>{{ $servidor->vinculo->nome_vinculo }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Descrição</label>
                                        <p class="text-gray-900" data-vinculo-descricao>{{ $servidor->vinculo->descricao ?? 'Não informado' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-1">Início do vinculo</label>
                                        <p class="text-gray-900" data-vinculo-data>
                                            {{ $servidor->vinculo->created_at ? \Carbon\Carbon::parse($servidor->vinculo->created_at)->format('d/m/Y') : 'Não informado' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                <p class="text-sm text-yellow-800">Nenhum vínculo atribuído no momento.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Seção: Formação e Cursos -->
                <div class="mb-8 pb-8 border-b border-gray-200">
                    <div class="mb-6">
                        <div class="flex items-center gap-2 border-b-2 border-blue-500 pb-3">
                            <h2 class="text-2xl font-bold text-gray-800">
                                <i class="fas fa-graduation-cap mr-2"></i>Formação e Cursos
                            </h2>
                        </div>
                    </div>

                    <!-- Abas -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button type="button" onclick="mostrarAba('formacao')" id="tab-formacao" 
                                class="tab-button active py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 flex items-center">
                                <i class="fas fa-graduation-cap mr-2"></i>Formação
                            </button>
                            <button type="button" onclick="mostrarAba('cursos')" id="tab-cursos" 
                                class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center">
                                <i class="fas fa-book mr-2"></i>Cursos
                            </button>
                        </nav>
                    </div>

                    <!-- Conteúdo da Aba Formação -->
                    <div id="conteudo-formacao" class="tab-content">
                        <div class="flex justify-end mb-4">
                            <button type="button" onclick="abrirModalFormacao()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-plus mr-2"></i> Adicionar Formação
                            </button>
                        </div>

                        <div id="lista-formacoes">
                            @if($servidor->formacoes && $servidor->formacoes->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Instituição</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nível</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ano Conclusão</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duração</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($servidor->formacoes as $formacao)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $formacao->curso }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $formacao->instituicao }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $formacao->nivel }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $formacao->ano_conclusao }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $formacao->duracao ?? '-' }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        <button type="button" onclick="abrirModalEditarFormacao({{ $formacao->id }}, '{{ addslashes($formacao->curso) }}', '{{ addslashes($formacao->instituicao) }}', '{{ $formacao->nivel }}', {{ $formacao->ano_conclusao }}, '{{ addslashes($formacao->duracao ?? '') }}', '{{ addslashes($formacao->descricao ?? '') }}')" 
                                                            class="text-blue-600 hover:text-blue-800 mr-3">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form action="{{ route('servidores.formacoes.destroy', [$servidor->id, $formacao->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover esta formação?')" class="inline">
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
                                <div class="text-center py-8 text-gray-500 bg-yellow-50 rounded-lg border border-yellow-200">
                                    <i class="fas fa-graduation-cap text-3xl mb-3"></i>
                                    <p>Nenhuma formação cadastrada</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Conteúdo da Aba Cursos -->
                    <div id="conteudo-cursos" class="tab-content hidden">
                        <div class="flex justify-end mb-4">
                            <button type="button" onclick="abrirModalCurso()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                                <i class="fas fa-plus mr-2"></i> Adicionar Curso
                            </button>
                        </div>

                        <div id="lista-cursos">
                            @if($servidor->cursos && $servidor->cursos->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Instituição</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Carga Horária</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data Conclusão</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($servidor->cursos as $curso)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $curso->nome }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $curso->instituicao }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $curso->carga_horaria }}h</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $curso->data_conclusao ? \Carbon\Carbon::parse($curso->data_conclusao)->format('d/m/Y') : '-' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $curso->tipo ?? '-' }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        <button type="button" onclick="abrirModalEditarCurso({{ $curso->id }}, '{{ addslashes($curso->nome) }}', '{{ addslashes($curso->instituicao) }}', {{ $curso->carga_horaria }}, '{{ $curso->data_conclusao ? \Carbon\Carbon::parse($curso->data_conclusao)->format('Y-m-d') : '' }}', '{{ $curso->tipo ?? '' }}', '{{ addslashes($curso->descricao ?? '') }}')" 
                                                            class="text-blue-600 hover:text-blue-800 mr-3">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form action="{{ route('servidores.cursos.destroy', [$servidor->id, $curso->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este curso?')" class="inline">
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
                                <div class="text-center py-8 text-gray-500 bg-yellow-50 rounded-lg border border-yellow-200">
                                    <i class="fas fa-book text-3xl mb-3"></i>
                                    <p>Nenhum curso cadastrado</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

            <!-- Seção: Dependentes -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-blue-500 pb-3">
                        <i class="fas fa-users mr-2"></i>Dependentes
                    </h2>
                    <button type="button" onclick="abrirModalDependente()"
                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition duration-200 flex items-center justify-center" title="Adicionar Dependente">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                @php
                    $dependentes = $servidor->dependentes ?? collect();
                @endphp
                @if ($dependentes->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($dependentes as $dependente)
                            <div class="rounded-lg p-4 bg-white">
                                <div class="flex items-center gap-2 mb-3">
                                    <h4 class="font-semibold text-gray-800">{{ $dependente->nome }}</h4>
                                    <button type="button" onclick="abrirModalEditarDependente({{ $dependente->id }}, '{{ $dependente->nome }}', '{{ $dependente->parentesco ?? '' }}', '{{ $dependente->data_nascimento ? \Carbon\Carbon::parse($dependente->data_nascimento)->format('Y-m-d') : '' }}', '{{ $dependente->cpf ?? '' }}', '{{ $dependente->genero ?? '' }}', {{ $servidor->id }})" 
                                        class="text-blue-600 hover:text-blue-800" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
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
                                    <form action="{{ route('servidores.dependentes.destroy', [$servidor->id, $dependente->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este dependente?')">
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

            <!-- Seção: Histórico de Pagamento -->
            <div class="mt-8 pt-8 border-t border-gray-200">
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
                                        $mesAnoValue = $pagamento->mes_ano ? \Carbon\Carbon::parse($pagamento->mes_ano)->format('Y-m') : '';
                                        $dataPagamentoRaw = $pagamento->getAttributes()['data_pagamento'] ?? null;
                                        $dataPagamentoFormatada = null;
                                        $dataPagamentoValue = $dataPagamentoRaw ? \Carbon\Carbon::parse($dataPagamentoRaw)->format('Y-m-d') : '';
                                        if ($dataPagamentoRaw) {
                                            try {
                                                $dataPagamentoFormatada = \Carbon\Carbon::parse($dataPagamentoRaw)->format('d/m/Y');
                                            } catch (\Exception $e) {
                                                $dataPagamentoFormatada = $dataPagamentoRaw;
                                            }
                                        }
                                        $observacoesRaw = $pagamento->getAttributes()['observacoes'] ?? null;
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
                                            <button type="button" onclick="abrirModalEditarPagamento({{ $pagamento->id }}, '{{ $mesAnoValue }}', {{ $pagamento->valor ?? 0 }}, '{{ $pagamento->status ?? 'pendente' }}', '{{ $dataPagamentoValue }}', '{{ addslashes($observacoesRaw ?? '') }}', {{ $servidor->id }})" 
                                                class="text-blue-600 hover:text-blue-800 mr-2" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('servidores.pagamentos.destroy', [$servidor->id, $pagamento->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este pagamento?')" class="inline">
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
                        <i class="fas fa-money-bill-wave text-3xl mb-3"></i>
                        <p>Nenhum pagamento registrado</p>
                    </div>
                @endif
                </div>

            <!-- Seção: Histórico de Férias -->
            <div class="mt-8 pt-8 border-t border-gray-200">
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
                                <div class="mb-3">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h4 class="font-semibold text-gray-800">Período {{ $loop->iteration }}</h4>
                                        <button type="button" onclick="abrirModalEditarFeria({{ $feria->id }}, '{{ $feria->data_inicio ? $feria->data_inicio->format('Y-m-d') : '' }}', '{{ $feria->data_fim ? $feria->data_fim->format('Y-m-d') : '' }}', {{ $feria->dias ?? 'null' }}, '{{ $feria->status ?? 'Pendente' }}', '{{ addslashes($feria->observacoes ?? '') }}', {{ $servidor->id }})" 
                                            class="text-blue-600 hover:text-blue-800" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
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
                                        <p class="text-gray-900">{{ $feria->dias ?? 'Não informado' }}</p>
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
                                        <p class="text-gray-900">{{ $feria->status ?? 'Não informado' }}</p>
                                    </div>
                                    @if($feria->observacoes)
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600">Observações</label>
                                            <p class="text-gray-900 text-sm">{{ $feria->observacoes }}</p>
                                        </div>
                                        @endif
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <form action="{{ route('servidores.ferias.destroy', [$servidor->id, $feria->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este período de férias?')">
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
            <div class="mt-8 pt-8 border-t border-gray-200">
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
                                            <button type="button" onclick="abrirModalEditarOcorrencia({{ $ocorrencia->id }}, '{{ addslashes($ocorrencia->tipo_ocorrencia) }}', '{{ $ocorrencia->data_ocorrencia ? $ocorrencia->data_ocorrencia->format('Y-m-d') : '' }}', '{{ $ocorrencia->status ?? 'pendente' }}', '{{ addslashes($ocorrencia->descricao ?? '') }}', '{{ addslashes($ocorrencia->observacoes ?? '') }}', {{ $servidor->id }})" 
                                                class="text-blue-600 hover:text-blue-800 mr-2" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('servidores.ocorrencias.destroy', [$servidor->id, $ocorrencia->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover esta ocorrência?')" class="inline">
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

            <!-- Botões de Navegação -->
                <div class="flex justify-end space-x-4 pt-8 border-t mt-8">
                    <a href="{{ route('servidores.show', $servidor->id) }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg transition duration-200">
                    Visualizar Servidor
                </a>
                <a href="{{ route('admin.colaborador') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg transition duration-200">
                    Voltar
                </a>
                </div>
        </div>
    </div>
@endsection

@push('scripts')
<style>
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
</style>
<script>
    // Função para aplicar máscara de CPF
    function aplicarMascaraCPF(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            input.value = value;
        }
    }

    // Função para aplicar máscara de telefone
    function aplicarMascaraTelefone(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length <= 11) {
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
            input.value = value;
        }
    }

    // Função para exibir notificação tipo toast (balãozinho)
    function exibirNotificacao(mensagem, tipo) {
        // Remover notificações anteriores
        const notificacoesAnteriores = document.querySelectorAll('.toast-notificacao');
        notificacoesAnteriores.forEach(n => n.remove());
        
        // Criar elemento de notificação (balãozinho)
        const notificacao = document.createElement('div');
        notificacao.className = 'toast-notificacao fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 border-2 border-green-600';
        notificacao.style.animation = 'slideIn 0.3s ease-out';
        notificacao.style.minWidth = '200px';
        notificacao.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.2)';
        
        // Ícone de check
        notificacao.innerHTML = `
            <i class="fas fa-check-circle text-2xl"></i>
            <span class="font-bold text-lg">${mensagem}</span>
        `;
        
        // Adicionar ao body
        document.body.appendChild(notificacao);
        
        // Remover após 2.5 segundos com animação de saída
        setTimeout(() => {
            notificacao.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => {
                if (notificacao.parentNode) {
                    notificacao.remove();
                }
            }, 300);
        }, 2500);
    }

    // Função para exibir mensagem em uma seção específica
    function exibirMensagemSecao(secao, mensagem, tipo) {
        // Se for sucesso, exibir notificação toast
        if (tipo === 'success') {
            exibirNotificacao('Salvo!', 'success');
        }
        
        // Também exibir mensagem na seção para erros
        if (tipo === 'error') {
            const mensagemDiv = document.getElementById('mensagem-' + secao);
            if (mensagemDiv) {
                mensagemDiv.innerHTML = '';
                const alertDiv = document.createElement('div');
                alertDiv.className = `bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative`;
                alertDiv.setAttribute('role', 'alert');
                alertDiv.innerHTML = `<span class="block sm:inline">${mensagem}</span>`;
                mensagemDiv.appendChild(alertDiv);

                // Remover mensagem após 5 segundos
                setTimeout(() => {
                    alertDiv.remove();
                }, 5000);
            }
        }
    }

    // Função para atualizar preview da foto
    function atualizarPreviewFoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const fotoContainer = document.getElementById('previewFoto');
                if (fotoContainer) {
                    fotoContainer.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    img.className = 'w-full h-full object-cover';
                    fotoContainer.appendChild(img);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Função para salvar uma seção específica
    function salvarSecao(secao) {
        const servidorId = document.getElementById('servidor_id').value;
        const formData = new FormData();
        const csrfToken = document.querySelector('input[name="_token"]').value;
        
        // Definir campos para cada seção
        const camposPorSecao = {
            'foto': ['foto'],
            'dados-pessoais': ['nome_completo', 'matricula', 'cpf', 'rg', 'data_nascimento', 'genero', 'estado_civil', 'email', 'telefone', 'endereco', 'raca_cor', 'tipo_sanguineo', 'pispasep'],
            'dados-profissionais': ['data_nomeacao', 'formacao', 'status'],
            'lotacao': ['id_lotacao'],
            'vinculo': ['id_vinculo']
        };

        const campos = camposPorSecao[secao];
        if (!campos) {
            console.error('Seção não encontrada:', secao);
            return;
        }

        // Coletar valores dos campos da seção
        campos.forEach(campo => {
            const input = document.getElementById(campo);
            if (input) {
                if (input.type === 'file') {
                    if (input.files && input.files[0]) {
                        formData.append(campo, input.files[0]);
                    }
                } else if (input.type === 'checkbox') {
                    formData.append(campo, input.checked ? 1 : 0);
                } else {
                    formData.append(campo, input.value || '');
                }
            }
        });

        // Adicionar método e token
        formData.append('_method', 'PUT');
        formData.append('_token', csrfToken);

        // Obter botão de salvar da seção
        const buttons = document.querySelectorAll(`button[onclick="salvarSecao('${secao}')"]`);
        const button = buttons[0];
        if (!button) return;

        const originalButtonHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        // Enviar via AJAX
        const url = `{{ route('servidores.update', ':id') }}`.replace(':id', servidorId);
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Sempre exibir "Salvo!" na notificação
                exibirMensagemSecao(secao, 'Salvo!', 'success');
                
                // Atualizar informações de Lotação/Vínculo se necessário
                if (secao === 'lotacao' && data.lotacao) {
                    atualizarInformacoesLotacao(data.lotacao);
                }
                if (secao === 'vinculo' && data.vinculo) {
                    atualizarInformacoesVinculo(data.vinculo);
                }
                
                // Atualizar preview da foto se necessário
                if (secao === 'foto' && data.foto_url) {
                    const fotoContainer = document.getElementById('previewFoto');
                    if (fotoContainer) {
                        fotoContainer.innerHTML = `<img src="${data.foto_url}" alt="Foto" class="w-full h-full object-cover">`;
                    }
                }
            } else {
                const errorMsg = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Erro ao salvar');
                exibirMensagemSecao(secao, errorMsg, 'error');
            }
        })
        .catch(error => {
            console.error('Erro ao salvar:', error);
            exibirMensagemSecao(secao, 'Erro ao salvar. Por favor, tente novamente.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalButtonHTML;
        });
    }

    // Função para atualizar informações de Lotação na tela
    function atualizarInformacoesLotacao(lotacao) {
        const container = document.getElementById('lotacao-info-container');
        if (!container) return;

        if (!lotacao) {
            container.innerHTML = '<div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200"><p class="text-sm text-yellow-800">Nenhuma lotação atribuída no momento.</p></div>';
            return;
        }

        // Recriar o HTML completo para garantir que todos os elementos sejam atualizados
        const statusHtml = lotacao.status 
            ? '<span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Ativa</span>'
            : '<span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Inativa</span>';

        container.innerHTML = `
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Lotação Atual</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nome da Lotação</label>
                        <p class="text-gray-900 font-semibold" data-lotacao-nome>${lotacao.nome_lotacao || 'Não informado'}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Sigla</label>
                        <p class="text-gray-900" data-lotacao-sigla>${lotacao.sigla || 'Não informado'}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Departamento</label>
                        <p class="text-gray-900" data-lotacao-departamento>${lotacao.departamento || 'Não informado'}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Localização</label>
                        <p class="text-gray-900" data-lotacao-localizacao>${lotacao.localizacao || 'Não informado'}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                        <p class="text-gray-900" data-lotacao-status>${statusHtml}</p>
                    </div>
                </div>
            </div>
        `;
    }

    // Função para atualizar informações de Dados Profissionais na tela
    function atualizarInformacoesDadosProfissionais(dadosProfissionais) {
        const container = document.getElementById('dados-profissionais-info-container');
        if (!container) return;

        if (!dadosProfissionais || (!dadosProfissionais.data_nomeacao && !dadosProfissionais.formacao && dadosProfissionais.status === undefined)) {
            container.innerHTML = '<div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200"><p class="text-sm text-yellow-800">Nenhum dado profissional informado no momento.</p></div>';
            return;
        }

        // Formatar data
        let dataNomeacaoFormatada = 'Não informado';
        if (dadosProfissionais.data_nomeacao) {
            const data = new Date(dadosProfissionais.data_nomeacao);
            dataNomeacaoFormatada = data.toLocaleDateString('pt-BR');
        }

        // Status HTML
        let statusHtml = 'Não informado';
        if (dadosProfissionais.status !== undefined) {
            statusHtml = dadosProfissionais.status 
                ? '<span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Ativo</span>'
                : '<span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Inativo</span>';
        }

        container.innerHTML = `
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Dados Profissionais Atuais</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Data Nomeação</label>
                        <p class="text-gray-900" data-dados-profissionais-data-nomeacao>${dataNomeacaoFormatada}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Formação</label>
                        <p class="text-gray-900" data-dados-profissionais-formacao>${dadosProfissionais.formacao || 'Não informado'}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                        <p class="text-gray-900" data-dados-profissionais-status>${statusHtml}</p>
                    </div>
                </div>
            </div>
        `;
    }

    // Função para atualizar informações de Vínculo na tela
    function atualizarInformacoesVinculo(vinculo) {
        const container = document.getElementById('vinculo-info-container');
        if (!container) return;

        if (!vinculo) {
            container.innerHTML = '<div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200"><p class="text-sm text-yellow-800">Nenhum vínculo atribuído no momento.</p></div>';
            return;
        }

        const vinculoNome = container.querySelector('[data-vinculo-nome]');
        const vinculoDesc = container.querySelector('[data-vinculo-descricao]');
        const vinculoData = container.querySelector('[data-vinculo-data]');

        if (vinculoNome) vinculoNome.textContent = vinculo.nome_vinculo || 'Não informado';
        if (vinculoDesc) vinculoDesc.textContent = vinculo.descricao || 'Não informado';
        if (vinculoData && vinculo.created_at) {
            const data = new Date(vinculo.created_at);
            vinculoData.textContent = data.toLocaleDateString('pt-BR') + ' ' + data.toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'});
        }
    }

    // Função para alternar entre abas
    function mostrarAba(aba) {
        // Ocultar todos os conteúdos
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remover classe active de todas as abas
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active', 'border-blue-500', 'text-blue-600');
            button.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Mostrar conteúdo da aba selecionada
        const conteudo = document.getElementById('conteudo-' + aba);
        if (conteudo) {
            conteudo.classList.remove('hidden');
        }
        
        // Ativar botão da aba selecionada
        const botao = document.getElementById('tab-' + aba);
        if (botao) {
            botao.classList.add('active', 'border-blue-500', 'text-blue-600');
            botao.classList.remove('border-transparent', 'text-gray-500');
        }
    }

    // Inicializar quando o DOM estiver pronto
    document.addEventListener('DOMContentLoaded', function() {
        // Aplicar máscaras
        const cpfInput = document.querySelector('.cpf');
        if (cpfInput) {
            cpfInput.addEventListener('input', function() {
                aplicarMascaraCPF(this);
            });
            if (cpfInput.value) {
                aplicarMascaraCPF(cpfInput);
            }
        }

        const telefoneInput = document.querySelector('.telefone');
        if (telefoneInput) {
            telefoneInput.addEventListener('input', function() {
                aplicarMascaraTelefone(this);
            });
            if (telefoneInput.value) {
                aplicarMascaraTelefone(telefoneInput);
            }
        }

        // Preview da foto
        const fotoInput = document.getElementById('foto');
        if (fotoInput) {
            fotoInput.addEventListener('change', function() {
                atualizarPreviewFoto(this);
            });
        }

        // Prevenir submit do formulário principal (já que temos botões individuais)
        const mainForm = document.getElementById('mainForm');
        if (mainForm) {
            mainForm.addEventListener('submit', function(e) {
                e.preventDefault();
            });
        }
    });

    // Funções para abrir e fechar modais
    function abrirModalDependente() {
        document.getElementById('modalDependente').classList.remove('hidden');
    }
    
    function fecharModalDependente() {
        document.getElementById('modalDependente').classList.add('hidden');
        const form = document.getElementById('formDependente');
        if (form) form.reset();
    }
    
    function abrirModalOcorrencia() {
        document.getElementById('modalOcorrencia').classList.remove('hidden');
    }
    
    function fecharModalOcorrencia() {
        document.getElementById('modalOcorrencia').classList.add('hidden');
        const form = document.getElementById('formOcorrencia');
        if (form) form.reset();
    }
    
    function abrirModalPagamento() {
        document.getElementById('modalPagamento').classList.remove('hidden');
    }
    
    function fecharModalPagamento() {
        document.getElementById('modalPagamento').classList.add('hidden');
        const form = document.getElementById('formPagamento');
        if (form) form.reset();
    }
    
    function abrirModalFeria() {
        document.getElementById('modalFeria').classList.remove('hidden');
    }
    
    function fecharModalFeria() {
        document.getElementById('modalFeria').classList.add('hidden');
        const form = document.getElementById('formFeria');
        if (form) form.reset();
    }

    // Funções para abrir modais de edição
    function abrirModalEditarDependente(id, nome, parentesco, dataNascimento, cpf, genero, servidorId) {
        document.getElementById('editDependenteId').value = id;
        document.getElementById('editDependenteServidorId').value = servidorId;
        document.getElementById('editDependenteNome').value = nome;
        document.getElementById('editDependenteParentesco').value = parentesco;
        document.getElementById('editDependenteDataNascimento').value = dataNascimento;
        document.getElementById('editDependenteCpf').value = cpf;
        document.getElementById('editDependenteGenero').value = genero;
        document.getElementById('modalEditarDependente').classList.remove('hidden');
    }
    
    function fecharModalEditarDependente() {
        document.getElementById('modalEditarDependente').classList.add('hidden');
    }
    
    function abrirModalEditarPagamento(id, mesAno, valor, status, dataPagamento, observacoes, servidorId) {
        document.getElementById('editPagamentoId').value = id;
        document.getElementById('editPagamentoServidorId').value = servidorId;
        document.getElementById('editPagamentoMesAno').value = mesAno;
        document.getElementById('editPagamentoValor').value = valor;
        document.getElementById('editPagamentoStatus').value = status;
        document.getElementById('editPagamentoDataPagamento').value = dataPagamento || '';
        document.getElementById('editPagamentoObservacoes').value = observacoes || '';
        document.getElementById('modalEditarPagamento').classList.remove('hidden');
    }
    
    function fecharModalEditarPagamento() {
        document.getElementById('modalEditarPagamento').classList.add('hidden');
    }
    
    function abrirModalEditarFeria(id, dataInicio, dataFim, dias, status, observacoes, servidorId) {
        document.getElementById('editFeriaId').value = id;
        document.getElementById('editFeriaServidorId').value = servidorId;
        document.getElementById('editFeriaDataInicio').value = dataInicio || '';
        document.getElementById('editFeriaDataFim').value = dataFim || '';
        document.getElementById('editFeriaDias').value = dias || '';
        document.getElementById('editFeriaStatus').value = status;
        document.getElementById('editFeriaObservacoes').value = observacoes || '';
        document.getElementById('modalEditarFeria').classList.remove('hidden');
    }
    
    function fecharModalEditarFeria() {
        document.getElementById('modalEditarFeria').classList.add('hidden');
    }
    
    function abrirModalEditarOcorrencia(id, tipo, dataOcorrencia, status, descricao, observacoes, servidorId) {
        document.getElementById('editOcorrenciaId').value = id;
        document.getElementById('editOcorrenciaServidorId').value = servidorId;
        document.getElementById('editOcorrenciaTipo').value = tipo;
        document.getElementById('editOcorrenciaDataOcorrencia').value = dataOcorrencia || '';
        document.getElementById('editOcorrenciaStatus').value = status;
        document.getElementById('editOcorrenciaDescricao').value = descricao || '';
        document.getElementById('editOcorrenciaObservacoes').value = observacoes || '';
        document.getElementById('modalEditarOcorrencia').classList.remove('hidden');
    }
    
    function fecharModalEditarOcorrencia() {
        document.getElementById('modalEditarOcorrencia').classList.add('hidden');
    }
    
    // Funções para modais de Dados Profissionais, Lotação e Vínculo
    function abrirModalEditarDadosProfissionais() {
        const servidorId = document.getElementById('servidor_id').value;
        document.getElementById('editDadosProfissionaisServidorId').value = servidorId;
        document.getElementById('editDadosProfissionaisDataNomeacao').value = '{{ $servidor->data_nomeacao ? \Carbon\Carbon::parse($servidor->data_nomeacao)->format('Y-m-d') : '' }}';
        document.getElementById('editDadosProfissionaisFormacao').value = '{{ addslashes($servidor->formacao ?? '') }}';
        document.getElementById('editDadosProfissionaisStatus').value = '{{ isset($servidor->status) ? ($servidor->status ? 1 : 0) : '' }}';
        
        // Atualizar título do modal dinamicamente
        const temDados = '{{ $servidor->data_nomeacao || $servidor->formacao || isset($servidor->status) ? 'true' : 'false' }}';
        const modalTitle = document.querySelector('#modalEditarDadosProfissionais h3');
        if (modalTitle) {
            modalTitle.textContent = temDados === 'true' ? 'Editar Dados Profissionais' : 'Adicionar Dados Profissionais';
        }
        
        document.getElementById('modalEditarDadosProfissionais').classList.remove('hidden');
    }
    
    function fecharModalEditarDadosProfissionais() {
        document.getElementById('modalEditarDadosProfissionais').classList.add('hidden');
    }
    
    function abrirModalEditarLotacao(id, nome, sigla, departamento, localizacao, status) {
        if (!id) {
            exibirNotificacao('Erro: Lotação não encontrada.', 'error');
            return;
        }
        
        document.getElementById('editLotacaoIdHidden').value = id;
        document.getElementById('editLotacaoNome').value = nome || '';
        document.getElementById('editLotacaoSigla').value = sigla || '';
        document.getElementById('editLotacaoDepartamento').value = departamento || '';
        document.getElementById('editLotacaoLocalizacao').value = localizacao || '';
        document.getElementById('editLotacaoStatus').value = status !== undefined ? status : 1;
        document.getElementById('modalEditarLotacao').classList.remove('hidden');
    }
    
    function fecharModalEditarLotacao() {
        document.getElementById('modalEditarLotacao').classList.add('hidden');
    }
    
    // Funções para modal de atribuir lotação
    function abrirModalAtribuirLotacao() {
        document.getElementById('modalAtribuirLotacao').classList.remove('hidden');
    }
    
    function fecharModalAtribuirLotacao() {
        document.getElementById('modalAtribuirLotacao').classList.add('hidden');
        // Resetar o select
        const select = document.getElementById('atribuirLotacaoId');
        if (select) {
            select.value = '';
        }
        // Resetar os campos de nova lotação
        const nomeInput = document.getElementById('atribuirLotacaoNome');
        const siglaInput = document.getElementById('atribuirLotacaoSigla');
        const departamentoInput = document.getElementById('atribuirLotacaoDepartamento');
        const localizacaoInput = document.getElementById('atribuirLotacaoLocalizacao');
        const statusSelect = document.getElementById('atribuirLotacaoStatus');
        if (nomeInput) nomeInput.value = '';
        if (siglaInput) siglaInput.value = '';
        if (departamentoInput) departamentoInput.value = '';
        if (localizacaoInput) localizacaoInput.value = '';
        if (statusSelect) statusSelect.value = '1';
    }
    
    function salvarAtribuirLotacao() {
        const form = document.getElementById('formAtribuirLotacao');
        const formData = new FormData(form);
        const servidorId = document.getElementById('servidor_id').value;
        const csrfToken = document.querySelector('input[name="_token"]').value;
        
        const lotacaoId = document.getElementById('atribuirLotacaoId').value;
        const nomeLotacao = document.getElementById('atribuirLotacaoNome').value;
        
        // Verificar se selecionou uma lotação existente ou está criando uma nova
        if (!lotacaoId && !nomeLotacao) {
            exibirNotificacao('Por favor, selecione uma lotação existente ou preencha o nome para criar uma nova.', 'error');
            return;
        }
        
        // Se está criando uma nova lotação, adicionar os campos
        if (!lotacaoId && nomeLotacao) {
            formData.append('nome_lotacao', nomeLotacao);
            formData.append('sigla', document.getElementById('atribuirLotacaoSigla').value || '');
            formData.append('departamento', document.getElementById('atribuirLotacaoDepartamento').value || '');
            formData.append('localizacao', document.getElementById('atribuirLotacaoLocalizacao').value || '');
            formData.append('status', document.getElementById('atribuirLotacaoStatus').value || '1');
            formData.append('criar_lotacao', '1'); // Flag para indicar que deve criar a lotação
        } else if (lotacaoId) {
            formData.append('id_lotacao', lotacaoId);
        }
        
        formData.append('_method', 'PUT');
        formData.append('_token', csrfToken);
        
        const button = form.querySelector('button[type="submit"]');
        const originalHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Salvando...';
        
        const url = `{{ route('servidores.update', ':id') }}`.replace(':id', servidorId);
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                exibirNotificacao('Lotação atribuída com sucesso!', 'success');
                
                // Atualizar informações de lotação na tela
                if (data.lotacao) {
                    atualizarInformacoesLotacao(data.lotacao);
                    
                    // Atualizar o botão de editar
                    const secaoLotacao = document.querySelector('#secao-lotacao .flex.items-center.gap-2');
                    if (secaoLotacao) {
                        const botaoAtual = secaoLotacao.querySelector('button');
                        if (botaoAtual) {
                            const nomeLotacao = (data.lotacao.nome_lotacao || '').replace(/'/g, "\\'");
                            const sigla = (data.lotacao.sigla || '').replace(/'/g, "\\'");
                            const departamento = (data.lotacao.departamento || '').replace(/'/g, "\\'");
                            const localizacao = (data.lotacao.localizacao || '').replace(/'/g, "\\'");
                            botaoAtual.outerHTML = `<button type="button" onclick="abrirModalEditarLotacao(${data.lotacao.id_lotacao}, '${nomeLotacao}', '${sigla}', '${departamento}', '${localizacao}', ${data.lotacao.status ? 1 : 0})" class="text-blue-600 hover:text-blue-800" title="Editar"><i class="fas fa-edit"></i></button>`;
                        }
                    }
                }
                
                // Fechar modal após um breve delay
                setTimeout(() => {
                    fecharModalAtribuirLotacao();
                }, 1000);
            } else {
                const errorMsg = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Erro ao atribuir lotação');
                exibirNotificacao(errorMsg, 'error');
            }
        })
        .catch(error => {
            console.error('Erro ao atribuir lotação:', error);
            exibirNotificacao('Erro ao atribuir lotação. Por favor, tente novamente.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }
    
    function abrirModalEditarVinculo() {
        const servidorId = document.getElementById('servidor_id').value;
        document.getElementById('editVinculoServidorId').value = servidorId;
        document.getElementById('modalEditarVinculo').classList.remove('hidden');
    }
    
    function fecharModalEditarVinculo() {
        document.getElementById('modalEditarVinculo').classList.add('hidden');
    }
    
    // Funções para modal de edição de foto
    function abrirModalEditarFoto() {
        document.getElementById('modalEditarFoto').classList.remove('hidden');
    }
    
    function fecharModalEditarFoto() {
        document.getElementById('modalEditarFoto').classList.add('hidden');
        // Resetar o input de arquivo
        const fotoInput = document.getElementById('fotoModal');
        if (fotoInput) {
            fotoInput.value = '';
        }
        // Restaurar preview original
        const fotoPreviewModal = document.getElementById('fotoPreviewModal');
        const imgFotoAtual = document.getElementById('imgFotoAtual');
        if (fotoPreviewModal && imgFotoAtual) {
            fotoPreviewModal.innerHTML = '';
            const img = imgFotoAtual.cloneNode(true);
            fotoPreviewModal.appendChild(img);
        } else if (fotoPreviewModal) {
            fotoPreviewModal.innerHTML = '<div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500"><i class="fas fa-user text-3xl"></i></div>';
        }
    }
    
    function previewFotoModal(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const fotoPreviewModal = document.getElementById('fotoPreviewModal');
                if (fotoPreviewModal) {
                    fotoPreviewModal.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    img.className = 'w-full h-full object-cover';
                    fotoPreviewModal.appendChild(img);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function salvarFoto() {
        const fotoInput = document.getElementById('fotoModal');
        if (!fotoInput || !fotoInput.files || !fotoInput.files[0]) {
            exibirNotificacao('Por favor, selecione uma foto para enviar.', 'error');
            return;
        }
        
        const servidorId = document.getElementById('servidor_id').value;
        const formData = new FormData();
        const csrfToken = document.querySelector('#formEditarFoto input[name="_token"]').value;
        
        formData.append('foto', fotoInput.files[0]);
        formData.append('_method', 'PUT');
        formData.append('_token', csrfToken);
        
        const button = document.querySelector('#formEditarFoto button[type="submit"]');
        const originalButtonHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Salvando...';
        
        const url = `{{ route('servidores.update', ':id') }}`.replace(':id', servidorId);
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Erro ao salvar foto');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                exibirNotificacao('Foto salva com sucesso!', 'success');
                
                // Atualizar preview da foto principal
                if (data.foto_url) {
                    // Adicionar timestamp para forçar reload da imagem
                    const fotoUrl = data.foto_url + '?v=' + new Date().getTime();
                    const fotoContainer = document.getElementById('previewFoto');
                    if (fotoContainer) {
                        fotoContainer.innerHTML = `<img src="${fotoUrl}" alt="Foto" class="w-full h-full object-cover">`;
                    }
                    
                    // Atualizar também o preview do modal
                    const fotoPreviewModal = document.getElementById('fotoPreviewModal');
                    if (fotoPreviewModal) {
                        fotoPreviewModal.innerHTML = `<img src="${fotoUrl}" alt="Foto" class="w-full h-full object-cover">`;
                    }
                }
                
                // Fechar modal após um breve delay
                setTimeout(() => {
                    fecharModalEditarFoto();
                }, 1000);
            } else {
                const errorMsg = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Erro ao salvar foto');
                exibirNotificacao(errorMsg, 'error');
            }
        })
        .catch(error => {
            console.error('Erro ao salvar foto:', error);
            exibirNotificacao(error.message || 'Erro ao salvar foto. Por favor, tente novamente.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalButtonHTML;
        });
    }
    
    // Funções para salvar via AJAX
    function salvarEditarDependente() {
        const form = document.getElementById('formEditarDependente');
        const formData = new FormData(form);
        const servidorId = document.getElementById('editDependenteServidorId').value;
        const dependenteId = document.getElementById('editDependenteId').value;
        
        const button = form.querySelector('button[type="submit"]');
        const originalHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        fetch(`/rh/servidores/${servidorId}/dependentes/${dependenteId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                exibirNotificacao('Salvo!', 'success');
                fecharModalEditarDependente();
                setTimeout(() => location.reload(), 1000);
            } else {
                const errorMsg = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Erro ao salvar');
                exibirNotificacao(errorMsg, 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            exibirNotificacao('Erro ao salvar. Por favor, tente novamente.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }
    
    function salvarEditarPagamento() {
        const form = document.getElementById('formEditarPagamento');
        const formData = new FormData(form);
        const servidorId = document.getElementById('editPagamentoServidorId').value;
        const pagamentoId = document.getElementById('editPagamentoId').value;
        
        const button = form.querySelector('button[type="submit"]');
        const originalHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        fetch(`/rh/servidores/${servidorId}/pagamentos/${pagamentoId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                exibirNotificacao('Salvo!', 'success');
                fecharModalEditarPagamento();
                setTimeout(() => location.reload(), 1000);
            } else {
                const errorMsg = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Erro ao salvar');
                exibirNotificacao(errorMsg, 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            exibirNotificacao('Erro ao salvar. Por favor, tente novamente.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }
    
    function salvarEditarFeria() {
        const form = document.getElementById('formEditarFeria');
        const formData = new FormData(form);
        const servidorId = document.getElementById('editFeriaServidorId').value;
        const feriaId = document.getElementById('editFeriaId').value;
        
        const button = form.querySelector('button[type="submit"]');
        const originalHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        fetch(`/rh/servidores/${servidorId}/ferias/${feriaId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                exibirNotificacao('Salvo!', 'success');
                fecharModalEditarFeria();
                setTimeout(() => location.reload(), 1000);
            } else {
                const errorMsg = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Erro ao salvar');
                exibirNotificacao(errorMsg, 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            exibirNotificacao('Erro ao salvar. Por favor, tente novamente.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }
    
    function salvarEditarOcorrencia() {
        const form = document.getElementById('formEditarOcorrencia');
        const formData = new FormData(form);
        const servidorId = document.getElementById('editOcorrenciaServidorId').value;
        const ocorrenciaId = document.getElementById('editOcorrenciaId').value;
        
        const button = form.querySelector('button[type="submit"]');
        const originalHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        fetch(`/rh/servidores/${servidorId}/ocorrencias/${ocorrenciaId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                exibirNotificacao('Salvo!', 'success');
                fecharModalEditarOcorrencia();
                setTimeout(() => location.reload(), 1000);
            } else {
                const errorMsg = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Erro ao salvar');
                exibirNotificacao(errorMsg, 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            exibirNotificacao('Erro ao salvar. Por favor, tente novamente.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }
    
    function salvarEditarDadosProfissionais() {
        const form = document.getElementById('formEditarDadosProfissionais');
        const formData = new FormData(form);
        const servidorId = document.getElementById('servidor_id').value;
        
        const button = form.querySelector('button[type="submit"]');
        const originalHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        // Adicionar método PUT
        formData.append('_method', 'PUT');
        
            fetch(`/rh/servidores/${servidorId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                exibirNotificacao('Dados profissionais salvos com sucesso!', 'success');
                
                // Atualizar informações de dados profissionais na tela
                if (data.servidor) {
                    const dadosProfissionais = {
                        data_nomeacao: data.servidor.data_nomeacao,
                        formacao: data.servidor.formacao,
                        status: data.servidor.status
                    };
                    atualizarInformacoesDadosProfissionais(dadosProfissionais);
                }
                
                // Fechar modal após um breve delay
                setTimeout(() => {
                    fecharModalEditarDadosProfissionais();
                }, 1000);
            } else {
                const errorMsg = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Erro ao salvar');
                exibirNotificacao(errorMsg, 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            exibirNotificacao('Erro ao salvar. Por favor, tente novamente.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }
    
    function salvarEditarLotacao() {
        const form = document.getElementById('formEditarLotacao');
        const formData = new FormData(form);
        const lotacaoId = document.getElementById('editLotacaoIdHidden').value;
        
        if (!lotacaoId) {
            exibirNotificacao('Erro: Lotação não encontrada.', 'error');
            return;
        }
        
        const button = form.querySelector('button[type="submit"]');
        const originalHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        // Adicionar método PUT
        formData.append('_method', 'PUT');
        
        fetch(`/rh/lotacoes/${lotacaoId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                exibirNotificacao('Salvo!', 'success');
                if (data.lotacao) {
                    atualizarInformacoesLotacao(data.lotacao);
                }
                fecharModalEditarLotacao();
            } else {
                const errorMsg = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Erro ao salvar');
                exibirNotificacao(errorMsg, 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            exibirNotificacao('Erro ao salvar. Por favor, tente novamente.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }
    
    function salvarEditarVinculo() {
        const form = document.getElementById('formEditarVinculo');
        const formData = new FormData(form);
        const servidorId = document.getElementById('servidor_id').value;
        
        const button = form.querySelector('button[type="submit"]');
        const originalHTML = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        // Adicionar método PUT
        formData.append('_method', 'PUT');
        
            fetch(`/rh/servidores/${servidorId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                exibirNotificacao('Salvo!', 'success');
                if (data.vinculo) {
                    atualizarInformacoesVinculo(data.vinculo);
                }
                fecharModalEditarVinculo();
            } else {
                const errorMsg = data.errors ? Object.values(data.errors).flat().join(', ') : (data.message || 'Erro ao salvar');
                exibirNotificacao(errorMsg, 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            exibirNotificacao('Erro ao salvar. Por favor, tente novamente.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
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
        <form id="formDependente" action="{{ route('servidores.dependentes.store', $servidor->id) }}" method="POST">
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
        <form id="formOcorrencia" action="{{ route('servidores.ocorrencias.store', $servidor->id) }}" method="POST">
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
        <form id="formPagamento" action="{{ route('servidores.pagamentos.store', $servidor->id) }}" method="POST">
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
        <form id="formFeria" action="{{ route('servidores.ferias.store', $servidor->id) }}" method="POST">
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

<!-- Modal para Editar Dependente -->
<div id="modalEditarDependente" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Editar Dependente</h3>
            <button onclick="fecharModalEditarDependente()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEditarDependente" onsubmit="event.preventDefault(); salvarEditarDependente();">
            @csrf
            @method('PUT')
            <input type="hidden" id="editDependenteId" name="id">
            <input type="hidden" id="editDependenteServidorId" name="servidor_id">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                    <input type="text" id="editDependenteNome" name="nome" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Parentesco</label>
                    <select id="editDependenteParentesco" name="parentesco" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Selecione</option>
                        <option value="Filho(a)">Filho(a)</option>
                        <option value="Cônjuge">Cônjuge</option>
                        <option value="Pai/Mãe">Pai/Mãe</option>
                        <option value="Outros">Outros</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Nascimento</label>
                    <input type="date" id="editDependenteDataNascimento" name="data_nascimento" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                    <input type="text" id="editDependenteCpf" name="cpf" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gênero</label>
                    <select id="editDependenteGenero" name="genero" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Selecione</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalEditarDependente()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-save mr-2"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Editar Pagamento -->
<div id="modalEditarPagamento" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Editar Pagamento</h3>
            <button onclick="fecharModalEditarPagamento()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEditarPagamento" onsubmit="event.preventDefault(); salvarEditarPagamento();">
            @csrf
            @method('PUT')
            <input type="hidden" id="editPagamentoId" name="id">
            <input type="hidden" id="editPagamentoServidorId" name="servidor_id">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mês/Ano (Competência) *</label>
                    <input type="month" id="editPagamentoMesAno" name="mes_ano" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Valor *</label>
                    <input type="number" id="editPagamentoValor" name="valor" step="0.01" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="0.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="editPagamentoStatus" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="pendente">Pendente</option>
                        <option value="pago">Pago</option>
                        <option value="atrasado">Atrasado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data do Pagamento</label>
                    <input type="date" id="editPagamentoDataPagamento" name="data_pagamento" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                    <textarea id="editPagamentoObservacoes" name="observacoes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalEditarPagamento()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-save mr-2"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Editar Férias -->
<div id="modalEditarFeria" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Editar Férias</h3>
            <button onclick="fecharModalEditarFeria()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEditarFeria" onsubmit="event.preventDefault(); salvarEditarFeria();">
            @csrf
            @method('PUT')
            <input type="hidden" id="editFeriaId" name="id">
            <input type="hidden" id="editFeriaServidorId" name="servidor_id">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Início *</label>
                    <input type="date" id="editFeriaDataInicio" name="data_inicio" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Fim</label>
                    <input type="date" id="editFeriaDataFim" name="data_fim" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dias</label>
                    <input type="number" id="editFeriaDias" name="dias" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="editFeriaStatus" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="Pendente">Pendente</option>
                        <option value="Aprovado">Aprovado</option>
                        <option value="Rejeitado">Rejeitado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                    <textarea id="editFeriaObservacoes" name="observacoes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalEditarFeria()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-save mr-2"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Editar Ocorrência -->
<div id="modalEditarOcorrencia" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Editar Ocorrência</h3>
            <button onclick="fecharModalEditarOcorrencia()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEditarOcorrencia" onsubmit="event.preventDefault(); salvarEditarOcorrencia();">
            @csrf
            @method('PUT')
            <input type="hidden" id="editOcorrenciaId" name="id">
            <input type="hidden" id="editOcorrenciaServidorId" name="servidor_id">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Ocorrência *</label>
                    <input type="text" id="editOcorrenciaTipo" name="tipo_ocorrencia" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ex: Advertência, Elogio, etc.">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data da Ocorrência *</label>
                    <input type="date" id="editOcorrenciaDataOcorrencia" name="data_ocorrencia" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                    <textarea id="editOcorrenciaDescricao" name="descricao" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="editOcorrenciaStatus" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="pendente">Pendente</option>
                        <option value="resolvida">Resolvida</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                    <textarea id="editOcorrenciaObservacoes" name="observacoes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalEditarOcorrencia()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-save mr-2"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Editar Dados Profissionais -->
<div id="modalEditarDadosProfissionais" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Editar Dados Profissionais</h3>
            <button onclick="fecharModalEditarDadosProfissionais()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEditarDadosProfissionais" onsubmit="event.preventDefault(); salvarEditarDadosProfissionais();">
            @csrf
            @method('PUT')
            <input type="hidden" id="editDadosProfissionaisServidorId" name="servidor_id">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Nomeação</label>
                    <input type="date" id="editDadosProfissionaisDataNomeacao" name="data_nomeacao" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Formação</label>
                    <input type="text" id="editDadosProfissionaisFormacao" name="formacao" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ex: Graduação em Direito">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="editDadosProfissionaisStatus" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalEditarDadosProfissionais()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-save mr-2"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Editar Lotação -->
<div id="modalEditarLotacao" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Editar Lotação</h3>
            <button onclick="fecharModalEditarLotacao()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEditarLotacao" onsubmit="event.preventDefault(); salvarEditarLotacao();">
            @csrf
            @method('PUT')
            <input type="hidden" id="editLotacaoIdHidden">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome da Lotação *</label>
                    <input type="text" id="editLotacaoNome" name="nome_lotacao" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ex: Polícia Civil">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sigla</label>
                    <input type="text" id="editLotacaoSigla" name="sigla" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ex: PC">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                    <input type="text" id="editLotacaoDepartamento" name="departamento" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ex: Segurança Pública">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Localização</label>
                    <input type="text" id="editLotacaoLocalizacao" name="localizacao" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ex: Sede Central">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="editLotacaoStatus" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="1">Ativa</option>
                        <option value="0">Inativa</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalEditarLotacao()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-save mr-2"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Atribuir Lotação -->
<div id="modalAtribuirLotacao" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Atribuir Lotação</h3>
            <button onclick="fecharModalAtribuirLotacao()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formAtribuirLotacao" onsubmit="event.preventDefault(); salvarAtribuirLotacao();">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Selecione uma Lotação Existente</label>
                    <select id="atribuirLotacaoId" name="id_lotacao" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Selecione uma lotação existente ou crie uma nova abaixo...</option>
                        @php
                            $lotacoesUnicas = $lotacoes->unique('id_lotacao');
                        @endphp
                        @foreach ($lotacoesUnicas as $lotacao)
                            <option value="{{ $lotacao->id_lotacao }}">
                                {{ $lotacao->nome_lotacao }}@if($lotacao->sigla) ({{ $lotacao->sigla }})@endif
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Ou preencha os campos abaixo para criar uma nova lotação</p>
                </div>
                
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <p class="text-sm font-medium text-gray-700 mb-3">Criar Nova Lotação</p>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nome da Lotação *</label>
                        <input type="text" id="atribuirLotacaoNome" name="nome_lotacao" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ex: Polícia Civil">
                    </div>
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sigla</label>
                        <input type="text" id="atribuirLotacaoSigla" name="sigla" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ex: PC">
                    </div>
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                        <input type="text" id="atribuirLotacaoDepartamento" name="departamento" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ex: Segurança Pública">
                    </div>
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Localização</label>
                        <input type="text" id="atribuirLotacaoLocalizacao" name="localizacao" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Ex: Sede Central">
                    </div>
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="atribuirLotacaoStatus" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="1">Ativa</option>
                            <option value="0">Inativa</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalAtribuirLotacao()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-save mr-2"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Editar Vínculo -->
<div id="modalEditarVinculo" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Editar Vínculo</h3>
            <button onclick="fecharModalEditarVinculo()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEditarVinculo" onsubmit="event.preventDefault(); salvarEditarVinculo();">
            @csrf
            @method('PUT')
            <input type="hidden" id="editVinculoServidorId" name="servidor_id">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vínculo *</label>
                    <select id="editVinculoId" name="id_vinculo" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Selecione um vínculo...</option>
                        @foreach ($vinculos as $vinculo)
                            <option value="{{ $vinculo->id_vinculo }}"
                                @if ($servidor->id_vinculo == $vinculo->id_vinculo) selected @endif>
                                {{ $vinculo->nome_vinculo }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalEditarVinculo()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-save mr-2"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Editar Foto -->
<div id="modalEditarFoto" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Editar Foto</h3>
            <button onclick="fecharModalEditarFoto()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEditarFoto" onsubmit="event.preventDefault(); salvarFoto();">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <!-- Preview da foto atual -->
                <div class="flex justify-center mb-4">
                    <div id="fotoPreviewModal" class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden border-4 border-white shadow-lg">
                        @if ($servidor->foto)
                            <img src="{{ asset('storage/' . $servidor->foto) }}" alt="Foto atual" id="imgFotoAtual" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">
                                <i class="fas fa-user text-3xl"></i>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Input de arquivo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Selecione uma nova foto</label>
                    <input type="file" id="fotoModal" name="foto" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg" onchange="previewFotoModal(this)">
                    <p class="text-xs text-gray-500 mt-1">Formatos aceitos: JPEG, PNG, JPG, GIF (máx. 2MB)</p>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="fecharModalEditarFoto()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-save mr-2"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>