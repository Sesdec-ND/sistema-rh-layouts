@extends($layout)

@section('title', 'Meu Perfil Pessoal')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Meu Perfil Pessoal</h1>
            <p class="text-gray-600 mt-2">Visualize suas informações pessoais - Acesso Universal</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('perfil-pessoal.edit') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                <i class="fas fa-edit mr-2"></i>
                Editar Perfil
            </a>
        </div>
    </div>

    <!-- Alert de Segurança -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <div class="flex items-center">
            <i class="fas fa-shield-alt text-blue-500 mr-3"></i>
            <div>
                <p class="text-blue-800 font-semibold">Acesso Seguro</p>
                <p class="text-blue-700 text-sm">Estas informações são restritas ao seu usuário apenas.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Coluna Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informações Pessoais -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-circle mr-2 text-blue-600"></i>
                    Informações Pessoais
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            {{ $user->name }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            {{ $user->email }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">CPF</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            {{ $user->cpf }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">RG</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            {{ $user->rg }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Telefone</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            {{ $dadosPessoais['telefone'] }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Data de Nascimento</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            {{ $dadosPessoais['data_nascimento'] }}
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Endereço</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            {{ $dadosPessoais['endereco'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações Profissionais -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-briefcase mr-2 text-green-600"></i>
                    Informações Profissionais
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cargo</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            {{ $dadosPessoais['cargo'] }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Departamento</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            {{ $dadosPessoais['departamento'] }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Data de Admissão</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            {{ $dadosPessoais['data_admissao'] }}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Salário Base</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            {{ $dadosPessoais['salario'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Lateral -->
        <div class="space-y-6">
            <!-- Ações Rápidas -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Ações Rápidas</h2>
                
                <div class="space-y-3">
                    <a href="{{ route('perfil-pessoal.edit') }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-semibold transition duration-200 flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Dados Pessoais
                    </a>
                    
                    <a href="{{ route('perfil-pessoal.contracheque') }}" 
                       class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-semibold transition duration-200 flex items-center justify-center">
                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                        Meus Contracheques
                    </a>
                    
                    <a href="{{ route('perfil-pessoal.documentos') }}" 
                       class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg font-semibold transition duration-200 flex items-center justify-center">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Meus Documentos
                    </a>
                </div>
            </div>

            <!-- Status do Perfil -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Status do Perfil</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Perfil Ativo</span>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $user->perfil->nomePerfil }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Cadastro</span>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                            Completo
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Última Atualização</span>
                        <span class="text-sm text-gray-600">01/12/2024</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection