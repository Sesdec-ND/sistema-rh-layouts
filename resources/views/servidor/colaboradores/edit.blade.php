@extends('layouts.admin')

@section('title', 'Editar Servidor')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Editar Servidor</h1>
                <p class="text-gray-600 mt-2">Atualize as informações do servidor</p>
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

        <!-- Formulário com Abas -->
        <div class="bg-white rounded-xl shadow-md">
            <!-- Navegação por Abas -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-4 overflow-x-auto">
                    <button type="button" onclick="abrirAba('pessoais')"
                        class="aba-nav py-4 px-4 border-b-2 border-blue-500 font-medium text-sm text-blue-600 whitespace-nowrap">
                        <i class="fas fa-user mr-2"></i>Dados Pessoais
                    </button>
                    <button type="button" onclick="abrirAba('funcionais')"
                        class="aba-nav py-4 px-4 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        <i class="fas fa-briefcase mr-2"></i>Dados Funcionais
                    </button>
                    <button type="button" onclick="abrirAba('dependentes')"
                        class="aba-nav py-4 px-4 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        <i class="fas fa-users mr-2"></i>Dependentes
                    </button>
                    {{-- <button type="button" onclick="abrirAba('ocorrencias')" 
                    class="aba-nav py-4 px-4 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    <i class="fas fa-exclamation-circle mr-2"></i>Ocorrências
                </button> --}}
                    <button type="button" onclick="abrirAba('pagamentos')"
                        class="aba-nav py-4 px-4 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        <i class="fas fa-money-bill-wave mr-2"></i>Pagamentos
                    </button>
                    <button type="button" onclick="abrirAba('ferias')"
                        class="aba-nav py-4 px-4 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        <i class="fas fa-umbrella-beach mr-2"></i>Férias
                    </button>
                    <button type="button" onclick="abrirAba('formacoes')"
                        class="aba-nav py-4 px-4 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        <i class="fas fa-graduation-cap mr-2"></i>Formações
                    </button>
                    <button type="button" onclick="abrirAba('cursos')"
                        class="aba-nav py-4 px-4 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        <i class="fas fa-book mr-2"></i>Cursos
                    </button>
                </nav>
            </div>

            <form action="{{ route('servidores.update', $servidor->id) }}" method="POST" enctype="multipart/form-data"
                class="p-8">
                @csrf
                @method('PUT')

                <!-- Aba Dados Pessoais -->
                <div id="aba-pessoais" class="aba-conteudo space-y-6">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Dados Pessoais</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Matrícula -->
                        <div>
                            <label for="matricula" class="block text-sm font-semibold text-gray-700 mb-2">Matrícula
                                *</label>
                            <input type="text" id="matricula" name="matricula"
                                value="{{ old('matricula', $servidor->matricula) }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Nome Completo -->
                        <div class="md:col-span-2">
                            <label for="nome_completo" class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo
                                *</label>
                            <input type="text" id="nome_completo" name="nome_completo"
                                value="{{ old('nome_completo', $servidor->nome_completo) }}" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- CPF -->
                        <div>
                            <label for="cpf" class="block text-sm font-semibold text-gray-700 mb-2">CPF *</label>
                            <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $servidor->cpf) }}"
                                required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- RG -->
                        <div>
                            <label for="rg" class="block text-sm font-semibold text-gray-700 mb-2">RG *</label>
                            <input type="text" id="rg" name="rg" value="{{ old('rg', $servidor->rg) }}"
                                required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $servidor->email) }}"
                                required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Data Nascimento -->
                        <div>
                            <label for="data_nascimento" class="block text-sm font-semibold text-gray-700 mb-2">Data
                                Nascimento *</label>
                            <input type="date" id="data_nascimento" name="data_nascimento"
                                value="{{ old('data_nascimento', $servidor->data_nascimento ? $servidor->data_nascimento->format('Y-m-d') : '') }}"
                                required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Gênero -->
                        <div>
                            <label for="genero" class="block text-sm font-semibold text-gray-700 mb-2">Gênero *</label>
                            <select id="genero" name="genero" required
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                <option value="Masculino" @if (old('genero', $servidor->genero) == 'Masculino') selected @endif>Masculino
                                </option>
                                <option value="Feminino" @if (old('genero', $servidor->genero) == 'Feminino') selected @endif>Feminino
                                </option>
                            </select>
                        </div>

                        <!-- Estado Civil -->
                        <div>
                            <label for="estado_civil" class="block text-sm font-semibold text-gray-700 mb-2">Estado
                                Civil</label>
                            <select id="estado_civil" name="estado_civil"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                <option value="Solteiro" @if (old('estado_civil', $servidor->estado_civil) == 'Solteiro') selected @endif>Solteiro(a)
                                </option>
                                <option value="Casado" @if (old('estado_civil', $servidor->estado_civil) == 'Casado') selected @endif>Casado(a)</option>
                                <option value="Divorciado" @if (old('estado_civil', $servidor->estado_civil) == 'Divorciado') selected @endif>Divorciado(a)
                                </option>
                                <option value="Viúvo" @if (old('estado_civil', $servidor->estado_civil) == 'Viúvo') selected @endif>Viúvo(a)</option>
                            </select>
                        </div>

                        <!-- Telefone -->
                        <div>
                            <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-2">Telefone</label>
                            <input type="text" id="telefone" name="telefone"
                                value="{{ old('telefone', $servidor->telefone) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Endereço -->
                        <div class="md:col-span-3">
                            <label for="endereco" class="block text-sm font-semibold text-gray-700 mb-2">Endereço</label>
                            <input type="text" id="endereco" name="endereco"
                                value="{{ old('endereco', $servidor->endereco) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Raça/Cor -->
                        <div>
                            <label for="raca_cor" class="block text-sm font-semibold text-gray-700 mb-2">Raça/Cor</label>
                            <select id="raca_cor" name="raca_cor"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                <option value="Branca" @if (old('raca_cor', $servidor->raca_cor) == 'Branca') selected @endif>Branca</option>
                                <option value="Preta" @if (old('raca_cor', $servidor->raca_cor) == 'Preta') selected @endif>Preta</option>
                                <option value="Parda" @if (old('raca_cor', $servidor->raca_cor) == 'Parda') selected @endif>Parda</option>
                                <option value="Amarela" @if (old('raca_cor', $servidor->raca_cor) == 'Amarela') selected @endif>Amarela</option>
                            </select>
                        </div>

                        <!-- Tipo Sanguíneo -->
                        <div>
                            <label for="tipo_sanguineo" class="block text-sm font-semibold text-gray-700 mb-2">Tipo
                                Sanguíneo</label>
                            <select id="tipo_sanguineo" name="tipo_sanguineo"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                        </div>

                        <!-- Foto -->
                        <div class="md:col-span-3">
                            <label for="foto" class="block text-sm font-semibold text-gray-700 mb-2">Foto</label>
                            @if ($servidor->foto)
                                <div class="mb-3">
                                    <img src="{{ Storage::url($servidor->foto) }}" alt="Foto atual"
                                        class="w-32 h-32 rounded-lg object-cover border">
                                    <p class="text-sm text-gray-600 mt-1">Foto atual</p>
                                </div>
                            @endif
                            <input type="file" id="foto" name="foto"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                </div>

                <!-- Aba Dados Funcionais -->
                <div id="aba-funcionais" class="aba-conteudo hidden space-y-6">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Dados Funcionais</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- PIS/PASEP -->
                        <div>
                            <label for="pispasep" class="block text-sm font-semibold text-gray-700 mb-2">PIS/PASEP</label>
                            <input type="text" id="pispasep" name="pispasep"
                                value="{{ old('pispasep', $servidor->pispasep) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Data Nomeação -->
                        <div>
                            <label for="data_nomeacao" class="block text-sm font-semibold text-gray-700 mb-2">Data
                                Nomeação</label>
                            <input type="date" id="data_nomeacao" name="data_nomeacao"
                                value="{{ old('data_nomeacao', $servidor->data_nomeacao ? $servidor->data_nomeacao->format('Y-m-d') : '') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <select id="status" name="status"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="1" @if (old('status', $servidor->status) == 1) selected @endif>Ativo</option>
                                <option value="0" @if (old('status', $servidor->status) == 0) selected @endif>Inativo</option>
                            </select>
                        </div>

                        <!-- Vínculo -->
                        <div>
                            <label for="id_vinculo" class="block text-sm font-semibold text-gray-700 mb-2">Vínculo</label>
                            <select id="id_vinculo" name="id_vinculo"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                @foreach (\App\Models\Vinculo::all() as $vinculo)
                                    <option value="{{ $vinculo->id }}"
                                        @if (old('id_vinculo', $servidor->id_vinculo) == $vinculo->id) selected @endif>
                                        {{ $vinculo->nomeVinculo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lotação -->
                        <div>
                            <label for="id_lotacao" class="block text-sm font-semibold text-gray-700 mb-2">Lotação</label>
                            <select id="id_lotacao" name="id_lotacao"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                @foreach (\App\Models\Lotacao::all() as $lotacao)
                                    <option value="{{ $lotacao->id }}"
                                        @if (old('id_lotacao', $servidor->id_lotacao) == $lotacao->id) selected @endif>
                                        {{ $lotacao->nomeLotacao }} @if ($lotacao->sigla)
                                            ({{ $lotacao->sigla }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cargo -->
                        <div>
                            <label for="cargo" class="block text-sm font-semibold text-gray-700 mb-2">Cargo</label>
                            <input type="text" id="cargo" name="cargo"
                                value="{{ old('cargo', $servidor->cargo) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Salário Base -->
                        <div>
                            <label for="salario_base" class="block text-sm font-semibold text-gray-700 mb-2">Salário
                                Base</label>
                            <input type="number" step="0.01" id="salario_base" name="salario_base"
                                value="{{ old('salario_base', $servidor->salario_base) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Aba Dependentes -->
                <div id="aba-dependentes" class="aba-conteudo hidden space-y-6">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Dependentes</h2>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nome do Dependente -->
                            <div>
                                <label for="dependente_nome" class="block text-sm font-semibold text-gray-700 mb-2">Nome
                                    do Dependente</label>
                                <input type="text" id="dependente_nome" name="dependente_nome"
                                    value="{{ old('dependente_nome') }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- Parentesco -->
                            <div>
                                <label for="dependente_parentesco"
                                    class="block text-sm font-semibold text-gray-700 mb-2">Parentesco</label>
                                <select id="dependente_parentesco" name="dependente_parentesco"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Selecione...</option>
                                    <option value="Filho(a)" @if (old('dependente_parentesco') == 'Filho(a)') selected @endif>Filho(a)
                                    </option>
                                    <option value="Cônjuge" @if (old('dependente_parentesco') == 'Cônjuge') selected @endif>Cônjuge
                                    </option>
                                    <option value="Pai" @if (old('dependente_parentesco') == 'Pai') selected @endif>Pai</option>
                                    <option value="Mãe" @if (old('dependente_parentesco') == 'Mãe') selected @endif>Mãe</option>
                                    <option value="Outros" @if (old('dependente_parentesco') == 'Outros') selected @endif>Outros
                                    </option>
                                </select>
                            </div>

                            <!-- Data Nascimento Dependente -->
                            <div>
                                <label for="dependente_data_nascimento"
                                    class="block text-sm font-semibold text-gray-700 mb-2">Data Nascimento</label>
                                <input type="date" id="dependente_data_nascimento" name="dependente_data_nascimento"
                                    value="{{ old('dependente_data_nascimento') }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- CPF Dependente -->
                            <div>
                                <label for="dependente_cpf"
                                    class="block text-sm font-semibold text-gray-700 mb-2">CPF</label>
                                <input type="text" id="dependente_cpf" name="dependente_cpf"
                                    value="{{ old('dependente_cpf') }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <button type="button"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i> Adicionar Dependente
                        </button>
                    </div>
                </div>

                <!-- Aba Ocorrências -->
                {{-- <div id="aba-ocorrencias" class="aba-conteudo hidden space-y-6">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Ocorrências</h2>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tipo Ocorrência -->
                        <div>
                            <label for="ocorrencia_tipo" class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Ocorrência</label>
                            <select id="ocorrencia_tipo" name="ocorrencia_tipo" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                <option value="Advertência" @if (old('ocorrencia_tipo') == 'Advertência') selected @endif>Advertência</option>
                                <option value="Elogio" @if (old('ocorrencia_tipo') == 'Elogio') selected @endif>Elogio</option>
                                <option value="Suspensão" @if (old('ocorrencia_tipo') == 'Suspensão') selected @endif>Suspensão</option>
                                <option value="Promoção" @if (old('ocorrencia_tipo') == 'Promoção') selected @endif>Promoção</option>
                                <option value="Outros" @if (old('ocorrencia_tipo') == 'Outros') selected @endif>Outros</option>
                            </select>
                        </div>

                        <!-- Data Ocorrência -->
                        <div>
                            <label for="ocorrencia_data" class="block text-sm font-semibold text-gray-700 mb-2">Data da Ocorrência</label>
                            <input type="date" id="ocorrencia_data" name="ocorrencia_data" value="{{ old('ocorrencia_data') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Descrição -->
                        <div class="md:col-span-2">
                            <label for="ocorrencia_descricao" class="block text-sm font-semibold text-gray-700 mb-2">Descrição</label>
                            <textarea id="ocorrencia_descricao" name="ocorrencia_descricao" rows="3"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('ocorrencia_descricao') }}</textarea>
                        </div>
                    </div>
                </div>
            </div> --}}

                <!-- Aba Pagamentos -->
                <div id="aba-pagamentos" class="aba-conteudo hidden space-y-6">
    <h2 class="text-xl font-semibold text-gray-700 border-b pb-3">Pagamentos</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Período -->
        <div>
            <label for="mes_ano" class="block text-sm font-semibold text-gray-700 mb-2">Período</label>
            <input type="month" id="mes_ano" name="mes_ano"
                value="{{ old('mes_ano', $servidor->mes_ano) }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
            <select id="status" name="status"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Selecione...</option>
                <option value="Pago" @if (old('status', $servidor->status) == 'Pago') selected @endif>Pago</option>
                <option value="Pendente" @if (old('status', $servidor->status) == 'Pendente') selected @endif>Pendente
                </option>
                <option value="Cancelado" @if (old('status', $servidor->status) == 'Cancelado') selected @endif>Cancelado
                </option>
            </select>
        </div>
    </div>

    <!-- Novo container para Observações abaixo de Status -->
     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Valor -->
        <div>
            <label for="valor" class="block text-sm font-semibold text-gray-700 mb-2">Valor</label>
            <input type="text" id="valor" name="valor"
                value="{{ old('valor', $servidor->valor) }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>


    <div>
        <label for="observacoes" class="block text-sm font-semibold text-gray-700 mb-2">Observações</label>
        <textarea id="observacoes" name="observacoes" rows="3"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('observacoes', $servidor->observacoes) }}</textarea>
    </div>

   
</div>

                <!-- Tipo Conta -->
                {{-- <div>
                        <label for="tipo_conta" class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Conta</label>
                        <select id="tipo_conta" name="tipo_conta" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Selecione...</option>
                            <option value="Corrente" @if (old('tipo_conta', $servidor->tipo_conta) == 'Corrente') selected @endif>Corrente</option>
                            <option value="Poupança" @if (old('tipo_conta', $servidor->tipo_conta) == 'Poupança') selected @endif>Poupança</option>
                            <option value="Salário" @if (old('tipo_conta', $servidor->tipo_conta) == 'Salário') selected @endif>Salário</option>
                        </select>
                    </div> --}}
        </div>
    </div>

    <!-- Aba Férias -->
    <div id="aba-ferias" class="aba-conteudo hidden space-y-6">
        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Férias</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Data Início Férias -->
            <div>
                <label for="ferias_inicio" class="block text-sm font-semibold text-gray-700 mb-2">Data
                    Início</label>
                <input type="date" id="ferias_inicio" name="ferias_inicio"
                    value="{{ old('ferias_inicio', $servidor->ferias_inicio ? $servidor->ferias_inicio->format('Y-m-d') : '') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Data Término Férias -->
            <div>
                <label for="ferias_termino" class="block text-sm font-semibold text-gray-700 mb-2">Data
                    Término</label>
                <input type="date" id="ferias_termino" name="ferias_termino"
                    value="{{ old('ferias_termino', $servidor->ferias_termino ? $servidor->ferias_termino->format('Y-m-d') : '') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Período Aquisitivo -->
            <div>
                <label for="periodo_aquisitivo" class="block text-sm font-semibold text-gray-700 mb-2">Período
                    Aquisitivo</label>
                <input type="text" id="periodo_aquisitivo" name="periodo_aquisitivo"
                    value="{{ old('periodo_aquisitivo', $servidor->periodo_aquisitivo) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ex: 2023-2024">
            </div>

            <!-- Dias Gozados -->
            <div>
                <label for="dias_gozados" class="block text-sm font-semibold text-gray-700 mb-2">Dias
                    Gozados</label>
                <input type="number" id="dias_gozados" name="dias_gozados"
                    value="{{ old('dias_gozados', $servidor->dias_gozados) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </div>

    <!-- Aba Formações -->
    <div id="aba-formacoes" class="aba-conteudo hidden space-y-6">
        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Formações</h2>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nível Formação -->
                <div>
                    <label for="formacao_nivel" class="block text-sm font-semibold text-gray-700 mb-2">Nível
                        de Formação</label>
                    <select id="formacao_nivel" name="formacao_nivel"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecione...</option>
                        <option value="Ensino Fundamental" @if (old('formacao_nivel') == 'Ensino Fundamental') selected @endif>
                            Ensino Fundamental</option>
                        <option value="Ensino Médio" @if (old('formacao_nivel') == 'Ensino Médio') selected @endif>Ensino
                            Médio</option>
                        <option value="Graduação" @if (old('formacao_nivel') == 'Graduação') selected @endif>Graduação
                        </option>
                        <option value="Pós-Graduação" @if (old('formacao_nivel') == 'Pós-Graduação') selected @endif>
                            Pós-Graduação</option>
                        <option value="Mestrado" @if (old('formacao_nivel') == 'Mestrado') selected @endif>Mestrado
                        </option>
                        <option value="Doutorado" @if (old('formacao_nivel') == 'Doutorado') selected @endif>Doutorado
                        </option>
                    </select>
                </div>

                <!-- Curso -->
                <div>
                    <label for="formacao_curso" class="block text-sm font-semibold text-gray-700 mb-2">Curso</label>
                    <input type="text" id="formacao_curso" name="formacao_curso" value="{{ old('formacao_curso') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Instituição -->
                <div>
                    <label for="formacao_instituicao"
                        class="block text-sm font-semibold text-gray-700 mb-2">Instituição</label>
                    <input type="text" id="formacao_instituicao" name="formacao_instituicao"
                        value="{{ old('formacao_instituicao') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Ano Conclusão -->
                <div>
                    <label for="formacao_ano_conclusao" class="block text-sm font-semibold text-gray-700 mb-2">Ano de
                        Conclusão</label>
                    <input type="number" id="formacao_ano_conclusao" name="formacao_ano_conclusao"
                        value="{{ old('formacao_ano_conclusao') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>
    </div>

    <!-- Aba Cursos -->
    <div id="aba-cursos" class="aba-conteudo hidden space-y-6">
        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Cursos</h2>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nome Curso -->
                <div>
                    <label for="curso_nome" class="block text-sm font-semibold text-gray-700 mb-2">Nome do
                        Curso</label>
                    <input type="text" id="curso_nome" name="curso_nome" value="{{ old('curso_nome') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Instituição Curso -->
                <div>
                    <label for="curso_instituicao"
                        class="block text-sm font-semibold text-gray-700 mb-2">Instituição</label>
                    <input type="text" id="curso_instituicao" name="curso_instituicao"
                        value="{{ old('curso_instituicao') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Carga Horária -->
                <div>
                    <label for="curso_carga_horaria" class="block text-sm font-semibold text-gray-700 mb-2">Carga
                        Horária</label>
                    <input type="number" id="curso_carga_horaria" name="curso_carga_horaria"
                        value="{{ old('curso_carga_horaria') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Data Conclusão -->
                <div>
                    <label for="curso_data_conclusao" class="block text-sm font-semibold text-gray-700 mb-2">Data de
                        Conclusão</label>
                    <input type="date" id="curso_data_conclusao" name="curso_data_conclusao"
                        value="{{ old('curso_data_conclusao') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>
    </div>

    <!-- Botões -->
    <div class="flex justify-end space-x-4 pt-8 border-t mt-8">
        <a href="{{ route('servidores.show', $servidor->id) }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg">
            Cancelar
        </a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
            <i class="fas fa-save mr-2"></i>Atualizar Servidor
        </button>
    </div>
    </form>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Sistema de Abas
        const abas = ['pessoais', 'funcionais', 'dependentes', 'pagamentos', 'ferias', 'formacoes', 'cursos'];
        let abaAtual = 0;

        function abrirAba(nomeAba) {
            // Esconde todas as abas
            document.querySelectorAll('.aba-conteudo').forEach(aba => {
                aba.classList.add('hidden');
            });

            // Remove estilo ativo de todas as abas
            document.querySelectorAll('.aba-nav').forEach(aba => {
                aba.classList.remove('border-blue-500', 'text-blue-600');
                aba.classList.add('border-transparent', 'text-gray-500');
            });

            // Mostra aba selecionada
            document.getElementById('aba-' + nomeAba).classList.remove('hidden');

            // Ativa estilo da aba selecionada
            const abaIndex = abas.indexOf(nomeAba);
            if (abaIndex !== -1) {
                abaAtual = abaIndex;
                document.querySelector(`[onclick="abrirAba('${nomeAba}')"]`).classList.add('border-blue-500',
                    'text-blue-600');
            }
        }

        // Inicializar primeira aba
        document.addEventListener('DOMContentLoaded', function() {
            abrirAba('pessoais');
        });
    </script>
@endpush
