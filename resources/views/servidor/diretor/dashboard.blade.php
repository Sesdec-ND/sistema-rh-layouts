@extends('layouts.app')

@section('title', 'Dashboard - Diretor')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard - Diretoria</h1>
            <p class="text-gray-600 mt-2">Visão geral do sistema (Modo Visualização)</p>
        </div>
        <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-eye mr-2"></i>
            Modo Visualização
        </div>
    </div>

    <!-- Cards de Visão Geral -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total de Colaboradores</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalColaboradores }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-green-600">
                <i class="fas fa-chart-line mr-1"></i>
                Crescimento de 8% este trimestre
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Ativos no Sistema</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalColaboradores - 2 }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-user-check text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <i class="fas fa-info-circle mr-1"></i>
                2 colaboradores inativos
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Departamentos</p>
                    <p class="text-3xl font-bold text-gray-800">6</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-sitemap text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <i class="fas fa-building mr-1"></i>
                Organização por áreas
            </div>
        </div>
    </div>

    <!-- Acesso Rápido -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Acesso Rápido</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Meu Perfil - Novo -->
            <a href="{{ route('perfil-pessoal.show') }}" 
               class="bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 p-4 rounded-lg transition duration-200 group">
                <div class="flex items-center">
                    <div class="bg-indigo-100 p-3 rounded-lg group-hover:bg-indigo-200 transition duration-200">
                        <i class="fas fa-user-circle text-indigo-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-800">Meu Perfil</h3>
                        <p class="text-sm text-gray-600">Dados pessoais</p>
                    </div>
                </div>
            </a>

            <!-- Visualizar Colaboradores -->
            <a href="{{ route('diretor.colaboradores') }}" 
               class="bg-blue-50 hover:bg-blue-100 border border-blue-200 p-4 rounded-lg transition duration-200 group">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-lg group-hover:bg-blue-200 transition duration-200">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-800">Visualizar Colaboradores</h3>
                        <p class="text-sm text-gray-600">Lista completa em modo leitura</p>
                    </div>
                </div>
            </a>

            <!-- Relatórios Detalhados - Desabilitado -->
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg opacity-75 cursor-not-allowed">
                <div class="flex items-center">
                    <div class="bg-gray-200 p-3 rounded-lg">
                        <i class="fas fa-chart-bar text-gray-400 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-500">Relatórios Detalhados</h3>
                        <p class="text-sm text-gray-400">Acesso restrito ao RH</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indicadores Chave -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Indicadores Chave</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Gráfico Simulado - Turnover -->
            <div>
                <h3 class="font-semibold text-gray-700 mb-4">Taxa de Turnover</h3>
                <div class="bg-gradient-to-r from-green-400 to-blue-500 h-4 rounded-full mb-2"></div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>12%</span>
                    <span>Meta: 15%</span>
                </div>
                <p class="text-sm text-green-600 mt-2">
                    <i class="fas fa-arrow-down mr-1"></i>
                    Dentro da meta estabelecida
                </p>
            </div>

            <!-- Gráfico Simulado - Satisfação -->
            <div>
                <h3 class="font-semibold text-gray-700 mb-4">Satisfação dos Colaboradores</h3>
                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-4 rounded-full mb-2"></div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>78%</span>
                    <span>Meta: 80%</span>
                </div>
                <p class="text-sm text-yellow-600 mt-2">
                    <i class="fas fa-chart-line mr-1"></i>
                    Próximo da meta
                </p>
            </div>
        </div>
    </div>

    <!-- Aviso de Permissão -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="bg-yellow-100 p-2 rounded-full mr-4">
                <i class="fas fa-info-circle text-yellow-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-yellow-800 text-lg mb-2">Modo de Visualização</h3>
                <p class="text-yellow-700">
                    Como Diretor Executivo, você tem acesso em modo de visualização aos dados do sistema. 
                    Para edições ou funcionalidades administrativas, entre em contato com o departamento de RH.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection