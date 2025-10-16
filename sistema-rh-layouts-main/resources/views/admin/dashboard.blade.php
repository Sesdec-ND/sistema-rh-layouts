@extends('layouts.admin')

@section('title', 'Dashboard - RH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard - Recursos Humanos</h1>
            <p class="text-gray-600 mt-2">Bem-vindo ao painel de controle do RH</p>
        </div>
        <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
            <i class="fas fa-user-shield mr-2"></i>
            Acesso Completo
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Colaboradores</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalColaboradores }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-green-600">
                <i class="fas fa-arrow-up mr-1"></i>
                12% desde último mês
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Perfis de Acesso</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPerfis }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-user-tag text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <i class="fas fa-info-circle mr-1"></i>
                3 perfis ativos
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Relatórios</p>
                    <p class="text-3xl font-bold text-gray-800">15</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <i class="fas fa-file-alt mr-1"></i>
                5 novos este mês
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pendências</p>
                    <p class="text-3xl font-bold text-gray-800">3</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-red-600">
                <i class="fas fa-clock mr-1"></i>
                Requer atenção
            </div>
        </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Ações Rápidas</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.colaborador') }}" 
               class="bg-blue-50 hover:bg-blue-100 border border-blue-200 p-4 rounded-lg transition duration-200 group">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-lg group-hover:bg-blue-200 transition duration-200">
                        <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-800">Gerenciar Colaboradores</h3>
                        <p class="text-sm text-gray-600">Adicionar, editar ou remover</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.relatorios') }}" 
               class="bg-green-50 hover:bg-green-100 border border-green-200 p-4 rounded-lg transition duration-200 group">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-lg group-hover:bg-green-200 transition duration-200">
                        <i class="fas fa-chart-pie text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-800">Relatórios</h3>
                        <p class="text-sm text-gray-600">Gerar e visualizar</p>
                    </div>
                </div>
            </a>

            <a href="#" 
               class="bg-purple-50 hover:bg-purple-100 border border-purple-200 p-4 rounded-lg transition duration-200 group">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-lg group-hover:bg-purple-200 transition duration-200">
                        <i class="fas fa-cog text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-800">Configurações</h3>
                        <p class="text-sm text-gray-600">Sistema e permissões</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Atividade Recente -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Atividade Recente</h2>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                <div class="flex items-center">
                    <div class="bg-green-100 p-2 rounded-full">
                        <i class="fas fa-user-plus text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold">Novo colaborador cadastrado</p>
                        <p class="text-sm text-gray-600">João Silva - Desenvolvedor</p>
                    </div>
                </div>
                <span class="text-sm text-gray-500">2 horas atrás</span>
            </div>
            
            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-2 rounded-full">
                        <i class="fas fa-file-alt text-blue-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold">Relatório gerado</p>
                        <p class="text-sm text-gray-600">Folha de pagamento - Dez/2024</p>
                    </div>
                </div>
                <span class="text-sm text-gray-500">1 dia atrás</span>
            </div>
        </div>
    </div>
</div>
@endsection