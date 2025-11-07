@extends('layouts.admin')

@section('title', 'Cadastrar Novo Servidor')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Cadastrar Novo Servidor</h1>
        </div>

        <!-- Formulário com Abas -->
        <div class="bg-white rounded-xl shadow-md">
            <!-- Navegação por Abas -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 overflow-x-auto">
                    <button type="button" onclick="abrirAba('pessoais')"
                        class="aba-nav py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 whitespace-nowrap">
                        Dados Pessoais
                    </button>
                    <button type="button" onclick="abrirAba('funcionais')"
                        class="aba-nav py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        Dados Funcionais
                    </button>
                    <button type="button" onclick="abrirAba('dependentes')"
                        class="aba-nav py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        Dependentes
                    </button>
                    <button type="button" onclick="abrirAba('pagamentos')"
                        class="aba-nav py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 whitespace-nowrap">
                        Pagamentos
                    </button>
                </nav>
            </div>

            <form action="{{ route('servidores.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf

                <!-- Aba Dados Pessoais -->
                <div id="aba-pessoais" class="aba-conteudo space-y-6">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Dados Pessoais</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Matrícula -->
                        <div>
                            <label for="matricula" class="block text-sm font-semibold text-gray-700 mb-2">Matrícula
                                *</label>
                            <input type="text" id="matricula" name="matricula" value="{{ old('matricula') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('matricula') border-red-500 @enderror">
                            @error('matricula')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nome Completo -->
                        <div class="md:col-span-2">
                            <label for="nome_completo" class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo
                                *</label>
                            <input type="text" id="nome_completo" name="nome_completo" value="{{ old('nome_completo') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nome_completo') border-red-500 @enderror">
                            @error('nome_completo')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- CPF -->
                        <div>
                            <label for="cpf" class="block text-sm font-semibold text-gray-700 mb-2">CPF *</label>
                            <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cpf') border-red-500 @enderror">
                            @error('cpf')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- RG -->
                        <div>
                            <label for="rg" class="block text-sm font-semibold text-gray-700 mb-2">RG *</label>
                            <input type="text" id="rg" name="rg" value="{{ old('rg') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('rg') border-red-500 @enderror">
                            @error('rg')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Data Nascimento -->
                        <div>
                            <label for="data_nascimento" class="block text-sm font-semibold text-gray-700 mb-2">Data
                                Nascimento *</label>
                            <input type="date" id="data_nascimento" name="data_nascimento"
                                value="{{ old('data_nascimento') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('data_nascimento') border-red-500 @enderror">
                            @error('data_nascimento')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Gênero -->
                        <div>
                            <label for="genero" class="block text-sm font-semibold text-gray-700 mb-2">Gênero *</label>
                            <select id="genero" name="genero"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                <option value="Masculino" @if (old('genero') == 'Masculino') selected @endif>Masculino
                                </option>
                                <option value="Feminino" @if (old('genero') == 'Feminino') selected @endif>Feminino</option>
                            </select>
                            @error('genero')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Estado Civil -->
                        <div>
                            <label for="estado_civil" class="block text-sm font-semibold text-gray-700 mb-2">Estado
                                Civil</label>
                            <select id="estado_civil" name="estado_civil"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                <option value="Solteiro" @if (old('estado_civil') == 'Solteiro') selected @endif>Solteiro(a)
                                </option>
                                <option value="Casado" @if (old('estado_civil') == 'Casado') selected @endif>Casado(a)</option>
                                <option value="Divorciado" @if (old('estado_civil') == 'Divorciado') selected @endif>Divorciado(a)
                                </option>
                                <option value="Viúvo" @if (old('estado_civil') == 'Viúvo') selected @endif>Viúvo(a)</option>
                            </select>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Telefone -->
                        <div>
                            <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-2">Telefone</label>
                            <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Endereço -->
                        <div class="md:col-span-3">
                            <label for="endereco" class="block text-sm font-semibold text-gray-700 mb-2">Endereço</label>
                            <input type="text" id="endereco" name="endereco" value="{{ old('endereco') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Raça/Cor -->
                        <div>
                            <label for="raca_cor" class="block text-sm font-semibold text-gray-700 mb-2">Raça/Cor</label>
                            <select id="raca_cor" name="raca_cor"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                <option value="Branca" @if (old('raca_cor') == 'Branca') selected @endif>Branca</option>
                                <option value="Preta" @if (old('raca_cor') == 'Preta') selected @endif>Preta</option>
                                <option value="Parda" @if (old('raca_cor') == 'Parda') selected @endif>Parda</option>
                                <option value="Amarela" @if (old('raca_cor') == 'Amarela') selected @endif>Amarela</option>
                            </select>
                        </div>

                        <!-- Tipo Sanguíneo -->
                        <div>
                            <label for="tipo_sanguineo" class="block text-sm font-semibold text-gray-700 mb-2">Tipo
                                Sanguíneo</label>
                            <select id="tipo_sanguineo" name="tipo_sanguineo"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione...</option>
                                <option value="A+" @if (old('tipo_sanguineo') == 'A+') selected @endif>A+</option>
                                <option value="A-" @if (old('tipo_sanguineo') == 'A-') selected @endif>A-</option>
                                <option value="B+" @if (old('tipo_sanguineo') == 'B+') selected @endif>B+</option>
                                <option value="B-" @if (old('tipo_sanguineo') == 'B-') selected @endif>B-</option>
                                <option value="AB+" @if (old('tipo_sanguineo') == 'AB+') selected @endif>AB+</option>
                                <option value="AB-" @if (old('tipo_sanguineo') == 'AB-') selected @endif>AB-</option>
                                <option value="O+" @if (old('tipo_sanguineo') == 'O+') selected @endif>O+</option>
                                <option value="O-" @if (old('tipo_sanguineo') == 'O-') selected @endif>O-</option>
                            </select>
                        </div>

                        <!-- Foto -->
                        <div>
                            <label for="foto" class="block text-sm font-semibold text-gray-700 mb-2">Foto</label>
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
                            <input type="text" id="pispasep" name="pispasep" value="{{ old('pispasep') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Data Nomeação -->
                        <div>
                            <label for="data_nomeacao" class="block text-sm font-semibold text-gray-700 mb-2">Data
                                Nomeação</label>
                            <input type="date" id="data_nomeacao" name="data_nomeacao"
                                value="{{ old('data_nomeacao') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <select id="status" name="status"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="1" selected>Ativo</option>
                                <option value="0">Inativo</option>
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
                                        @if (old('id_vinculo') == $vinculo->id) selected @endif>
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
                                        @if (old('id_lotacao') == $lotacao->id) selected @endif>
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
                            <input type="text" id="cargo" name="cargo" value="{{ old('cargo') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Salário Base -->
                        <div>
                            <label for="salario_base" class="block text-sm font-semibold text-gray-700 mb-2">Salário
                                Base</label>
                            <input type="number" step="0.01" id="salario_base" name="salario_base"
                                value="{{ old('salario_base') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Formações Acadêmicas -->
                    <div class="mt-8">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Formações Acadêmicas</h3>
                            <button type="button" onclick="adicionarFormacao()"
                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                + Adicionar Formação
                            </button>
                        </div>
                        <div id="formacoes-container" class="space-y-4">
                            <!-- Formações serão adicionadas aqui -->
                        </div>
                    </div>
                </div>

                <!-- Aba Dependentes -->
                <div id="aba-dependentes" class="aba-conteudo hidden space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Dependentes</h2>
                        <button type="button" onclick="adicionarDependente()"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                            + Adicionar Dependente
                        </button>
                    </div>
                    <div id="dependentes-container" class="space-y-4">
                        <!-- Dependentes serão adicionados aqui -->
                    </div>
                </div>

                <!-- Aba Pagamentos -->
                <div id="aba-pagamentos" class="aba-conteudo hidden space-y-6">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Pagamentos</h2>

                    <!-- Dados Bancários -->
                    {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="banco" class="block text-sm font-semibold text-gray-700 mb-2">Banco</label>
                        <input type="text" id="banco" name="banco" value="{{ old('banco') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="agencia" class="block text-sm font-semibold text-gray-700 mb-2">Agência</label>
                        <input type="text" id="agencia" name="agencia" value="{{ old('agencia') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="conta_corrente" class="block text-sm font-semibold text-gray-700 mb-2">Conta Corrente</label>
                        <input type="text" id="conta_corrente" name="conta_corrente" value="{{ old('conta_corrente') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="tipo_conta" class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Conta</label>
                        <select id="tipo_conta" name="tipo_conta" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Selecione...</option>
                            <option value="Corrente" @if (old('tipo_conta') == 'Corrente') selected @endif>Corrente</option>
                            <option value="Poupança" @if (old('tipo_conta') == 'Poupança') selected @endif>Poupança</option>
                            <option value="Salário" @if (old('tipo_conta') == 'Salário') selected @endif>Salário</option>
                        </select>
                    </div>
                </div> --}}

                    <!-- Histórico de Pagamentos -->
                    <div class="border-t pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Histórico de Pagamentos</h3>
                            <button type="button" onclick="adicionarPagamento()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                                + Adicionar Pagamento
                            </button>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <div class="grid grid-cols-5 gap-4 text-sm font-semibold text-gray-700 mb-2">
                                <div>Mês/Ano</div>
                                <div>Valor</div>
                                <div>Status</div>
                                <div>Observações</div>
                            </div>
                            <div id="pagamentos-container" class="space-y-3">
                                <!-- Pagamentos serão adicionados aqui dinamicamente -->
                            </div>
                        </div>
                    </div>

                    <!-- Férias -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Férias</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="ferias_inicio" class="block text-sm font-semibold text-gray-700 mb-2">Data
                                    Início</label>
                                <input type="date" id="ferias_inicio" name="ferias_inicio"
                                    value="{{ old('ferias_inicio') }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="ferias_termino" class="block text-sm font-semibold text-gray-700 mb-2">Data
                                    Término</label>
                                <input type="date" id="ferias_termino" name="ferias_termino"
                                    value="{{ old('ferias_termino') }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="periodo_aquisitivo"
                                    class="block text-sm font-semibold text-gray-700 mb-2">Período Aquisitivo</label>
                                <input type="text" id="periodo_aquisitivo" name="periodo_aquisitivo"
                                    value="{{ old('periodo_aquisitivo') }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ex: 2023-2024">
                            </div>

                            <div>
                                <label for="dias_gozados" class="block text-sm font-semibold text-gray-700 mb-2">Dias
                                    Gozados</label>
                                <input type="number" id="dias_gozados" name="dias_gozados"
                                    value="{{ old('dias_gozados', 0) }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    min="0" max="30">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botões de Navegação e Submit -->
                <div class="flex justify-between pt-8 border-t mt-8">
                    <div class="flex space-x-3">
                        <button type="button" onclick="abaAnterior()"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">
                            ← Anterior
                        </button>
                        <button type="button" onclick="proximaAba()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            Próxima →
                        </button>
                    </div>

                    <div class="flex space-x-3">
                        <a href="{{ route('servidores.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                            Salvar Servidor
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Contadores para as abas dinâmicas
        let contadorFormacoes = 0;
        let contadorDependentes = 0;
        let contadorPagamentos = 0;

        // Sistema de Abas
        const abas = ['pessoais', 'funcionais', 'dependentes', 'pagamentos'];
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

        function proximaAba() {
            if (abaAtual < abas.length - 1) {
                abrirAba(abas[abaAtual + 1]);
            }
        }

        function abaAnterior() {
            if (abaAtual > 0) {
                abrirAba(abas[abaAtual - 1]);
            }
        }

        // Funções para adicionar itens dinâmicos
        function adicionarFormacao() {
            contadorFormacoes++;
            const novaFormacao = `
            <div class="formacao-item border border-gray-200 rounded-lg p-4 bg-white">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-semibold text-gray-700">Formação ${contadorFormacoes}</h4>
                    <button type="button" onclick="removerFormacao(this)" class="text-red-600 hover:text-red-800 text-lg">✕</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="formacoes[${contadorFormacoes-1}][curso]" placeholder="Curso" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="text" name="formacoes[${contadorFormacoes-1}][instituicao]" placeholder="Instituição" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="text" name="formacoes[${contadorFormacoes-1}][nivel]" placeholder="Nível (Graduação, Mestrado, etc.)" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="number" name="formacoes[${contadorFormacoes-1}][ano_conclusao]" placeholder="Ano Conclusão" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        `;
            document.getElementById('formacoes-container').insertAdjacentHTML('beforeend', novaFormacao);
        }

        function adicionarDependente() {
            contadorDependentes++;
            const novoDependente = `
            <div class="dependente-item border border-gray-200 rounded-lg p-4 bg-white">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-semibold text-gray-700">Dependente ${contadorDependentes}</h4>
                    <button type="button" onclick="removerDependente(this)" class="text-red-600 hover:text-red-800 text-lg">✕</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="dependentes[${contadorDependentes-1}][nome]" placeholder="Nome completo" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="text" name="dependentes[${contadorDependentes-1}][parentesco]" placeholder="Parentesco" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="date" name="dependentes[${contadorDependentes-1}][data_nascimento]" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="text" name="dependentes[${contadorDependentes-1}][cpf]" placeholder="CPF" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        `;
            document.getElementById('dependentes-container').insertAdjacentHTML('beforeend', novoDependente);
        }

        function adicionarPagamento() {
    contadorPagamentos++;
    const novoPagamento = `
        <div class="pagamento-item grid grid-cols-5 gap-4 items-center p-3 bg-white border border-gray-200 rounded">
            <input type="month" name="historicos_pagamento[${contadorPagamentos-1}][mes_ano]" 
                class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <input type="number" step="0.01" name="historicos_pagamento[${contadorPagamentos-1}][valor]" 
                placeholder="Valor R$" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <select name="historicos_pagamento[${contadorPagamentos-1}][status]" 
                class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="Pendente">Pendente</option>
                <option value="Pago">Pago</option>
                <option value="Cancelado">Cancelado</option>
            </select>
            <textarea name="historicos_pagamento[${contadorPagamentos-1}][observacoes]" rows="1"
                placeholder="Observações" class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            <button type="button" onclick="removerPagamento(this)" class="text-red-600 hover:text-red-800 text-lg justify-self-center">✕</button>
        </div>
    `;
    document.getElementById('pagamentos-container').insertAdjacentHTML('beforeend', novoPagamento);
}


        // Funções para remover itens
        function removerFormacao(botao) {
            botao.closest('.formacao-item').remove();
        }

        function removerDependente(botao) {
            botao.closest('.dependente-item').remove();
        }

        function removerPagamento(botao) {
            botao.closest('.pagamento-item').remove();
        }

        // Inicializar primeira aba
        document.addEventListener('DOMContentLoaded', function() {
            abrirAba('pessoais');
            // Adicionar primeiro dependente automaticamente
            adicionarDependente();
        });
    </script>
@endpush
