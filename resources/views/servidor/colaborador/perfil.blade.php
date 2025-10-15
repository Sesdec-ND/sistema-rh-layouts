@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Meu Perfil</h1>
            <p class="text-gray-600 mt-2">Gerencie suas informações pessoais</p>
        </div>
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg">
            <i class="fas fa-user-check mr-2"></i>
            Perfil Pessoal
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Coluna Esquerda - Informações Pessoais -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Card de Informações Pessoais -->
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
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                        {{ $user->username }}
                    </div>
                </div>
            </div>

            <!-- Card de Informações Profissionais -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-briefcase mr-2 text-green-600"></i>
                    Informações Profissionais
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Departamento</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            Tecnologia da Informação
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cargo</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            Desenvolvedor
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Data de Admissão</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-800">
                            15/03/2023
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Perfil de Acesso</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg">
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $user->perfil->nomePerfil }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Direita - Ações e Status -->
        <div class="space-y-6">
            <!-- Card de Status -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Status do Perfil</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Conta</span>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                            Ativa
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Documentos</span>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                            Completo
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Dados Pessoais</span>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                            Revisar
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Última Atualização</span>
                        <span class="text-sm text-gray-600">01/12/2024</span>
                    </div>
                </div>
            </div>

            <!-- Card de Ações Rápidas -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Ações Rápidas</h2>
                
                <div class="space-y-3">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-semibold transition duration-200 flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>
                        Solicitar Edição
                    </button>
                    
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-semibold transition duration-200 flex items-center justify-center">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Baixar Contracheque
                    </button>
                    
                    <button class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg font-semibold transition duration-200 flex items-center justify-center">
                        <i class="fas fa-key mr-2"></i>
                        Alterar Senha
                    </button>
                </div>
            </div>

            <!-- Card de Contato -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <h2 class="text-xl font-bold text-blue-800 mb-4 flex items-center">
                    <i class="fas fa-headset mr-2"></i>
                    Precisa de Ajuda?
                </h2>
                <p class="text-blue-700 mb-4">
                    Para alterações em seus dados cadastrais, entre em contato com o departamento de RH.
                </p>
                <div class="space-y-2">
                    <div class="flex items-center text-blue-700">
                        <i class="fas fa-envelope mr-2"></i>
                        <span class="text-sm">rh@empresa.com</span>
                    </div>
                    <div class="flex items-center text-blue-700">
                        <i class="fas fa-phone mr-2"></i>
                        <span class="text-sm">(11) 9999-9999</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações de Segurança -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="bg-yellow-100 p-2 rounded-full mr-4">
                <i class="fas fa-shield-alt text-yellow-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-yellow-800 text-lg mb-2">Segurança da Conta</h3>
                <p class="text-yellow-700 mb-3">
                    Mantenha suas informações seguras. Não compartilhe sua senha com ninguém.
                </p>
                <ul class="text-yellow-700 list-disc list-inside space-y-1 text-sm">
                    <li>Altere sua senha regularmente</li>
                    <li>Use uma senha forte com letras, números e símbolos</li>
                    <li>Nunca compartilhe suas credenciais de acesso</li>
                    <li>Desconecte-se ao terminar de usar o sistema</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection