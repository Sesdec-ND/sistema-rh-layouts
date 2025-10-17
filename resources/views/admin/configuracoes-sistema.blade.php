@extends('layouts.admin')

@section('title', 'Configurações do Sistema - RH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Configurações do Sistema</h1>
            <p class="text-gray-600 mt-2">Configure as preferências e comportamento do sistema</p>
        </div>
        <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
            <i class="fas fa-cogs mr-2"></i>
            Configurações Gerais
        </div>
    </div>

    <!-- Cards de Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Sistema</p>
                    <p class="text-2xl font-bold text-gray-800">Ativo</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-green-600">
                <i class="fas fa-server mr-1"></i>
                Todas as funções operacionais
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Backup</p>
                    <p class="text-2xl font-bold text-gray-800">Ativo</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-database text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <i class="fas fa-calendar mr-1"></i>
                Diário - 02:00 AM
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Última Atualização</p>
                    <p class="text-2xl font-bold text-gray-800">Hoje</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-clock text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <i class="fas fa-user mr-1"></i>
                Por: Administrador
            </div>
        </div>
    </div>

    <!-- Formulário de Configurações -->
    <form action="{{ route('admin.configuracoes-sistema.update') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Configurações Gerais -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center mb-6">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <i class="fas fa-sliders-h text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Configurações Gerais</h2>
                        <p class="text-gray-600">Preferências básicas do sistema</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Itens por Página</label>
                        <input type="number" name="geral[itens_por_pagina]" 
                               value="{{ $configuracoes['geral']['itens_por_pagina'] ?? 15 }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               min="5" max="100">
                        <p class="text-sm text-gray-500 mt-1">Número de itens exibidos nas listagens</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fuso Horário</label>
                        <select name="geral[timezone]" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="America/Sao_Paulo" selected>America/Sao_Paulo (Brasília)</option>
                            <option value="UTC">UTC</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Idioma do Sistema</label>
                        <select name="geral[idioma]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="pt_BR" selected>Português (Brasil)</option>
                            <option value="en">English</option>
                            <option value="es">Español</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Configurações de Interface -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center mb-6">
                    <div class="bg-purple-100 p-3 rounded-full mr-4">
                        <i class="fas fa-palette text-purple-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Interface do Usuário</h2>
                        <p class="text-gray-600">Personalização da aparência</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tema do Sistema</label>
                        <select name="interface[tema]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="claro" selected>Claro</option>
                            <option value="escuro">Escuro</option>
                            <option value="auto">Automático</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Densidade da Interface</label>
                        <select name="interface[densidade]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="confortavel" selected>Confortável</option>
                            <option value="compacto">Compacto</option>
                            <option value="espacoso">Espaçoso</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Modo de Manutenção</label>
                            <p class="text-sm text-gray-500">Restringe o acesso ao sistema</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="sistema[modo_manutencao]" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações -->
        <div class="bg-white rounded-xl shadow-md p-6 mt-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Salvar Configurações</h3>
                    <p class="text-gray-600">As alterações serão aplicadas imediatamente</p>
                </div>
                <div class="flex space-x-3">
                    <button type="button" 
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Salvar Configurações
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Informações do Sistema -->
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informações do Sistema</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg">
                <div class="text-sm text-gray-500">Versão</div>
                <div class="text-lg font-semibold text-gray-800">v2.1.0</div>
            </div>
            <div class="bg-white p-4 rounded-lg">
                <div class="text-sm text-gray-500">Último Backup</div>
                <div class="text-lg font-semibold text-gray-800">Hoje - 02:15</div>
            </div>
            <div class="bg-white p-4 rounded-lg">
                <div class="text-sm text-gray-500">Status</div>
                <div class="text-lg font-semibold text-green-600">Operacional</div>
            </div>
        </div>
    </div>
</div>
@endsection