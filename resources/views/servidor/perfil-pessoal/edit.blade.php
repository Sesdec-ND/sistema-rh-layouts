@extends($layout)

@section('title', 'Editar Perfil Pessoal')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Editar Perfil Pessoal</h1>
            <p class="text-gray-600 mt-2">Atualize suas informações pessoais editáveis</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('perfil-pessoal.show') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar ao Perfil
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <form method="POST" action="{{ route('perfil-pessoal.update') }}">
            @csrf
            @method('PUT')

            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-user-edit mr-2 text-blue-600"></i>
                Dados Pessoais Editáveis
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Telefone *</label>
                    <input type="text" 
                           name="telefone" 
                           value="{{ old('telefone', $dadosPessoais['telefone'] ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('telefone')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Data de Nascimento *</label>
                    <input type="date" 
                           name="data_nascimento" 
                           value="{{ old('data_nascimento', $dadosPessoais['data_nascimento'] ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('data_nascimento')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Endereço Completo *</label>
                    <textarea name="endereco" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              required>{{ old('endereco', $dadosPessoais['endereco'] ?? '') }}</textarea>
                    @error('endereco')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Estado Civil *</label>
                    <select name="estado_civil" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <option value="">Selecione...</option>
                        <option value="Solteiro(a)" {{ old('estado_civil', $dadosPessoais['estado_civil']) == 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)</option>
                        <option value="Casado(a)" {{ old('estado_civil', $dadosPessoais['estado_civil']) == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                        <option value="Divorciado(a)" {{ old('estado_civil', $dadosPessoais['estado_civil']) == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                        <option value="Viúvo(a)" {{ old('estado_civil', $dadosPessoais['estado_civil']) == 'Viúvo(a)' ? 'selected' : '' }}>Viúvo(a)</option>
                        <option value="União Estável" {{ old('estado_civil', $dadosPessoais['estado_civil']) == 'União Estável' ? 'selected' : '' }}>União Estável</option>
                    </select>
                    @error('estado_civil')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Informações não editáveis -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-gray-500"></i>
                    Informações Administrativas (Somente Leitura)
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-600">
                            {{ $user->name }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">CPF</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-600">
                            {{ $user->cpf }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cargo</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-600">
                            {{ $dadosPessoais['cargo'] }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Departamento</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-600">
                            {{ $dadosPessoais['departamento'] }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('perfil-pessoal.show') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>

    <!-- Aviso de Segurança -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="bg-yellow-100 p-2 rounded-full mr-4">
                <i class="fas fa-shield-alt text-yellow-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-yellow-800 text-lg mb-2">Informação de Segurança</h3>
                <p class="text-yellow-700">
                    Para alterações em dados cadastrais como nome, CPF, cargo ou salário, 
                    entre em contato com o departamento de RH. Apenas informações pessoais 
                    básicas podem ser editadas aqui.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection