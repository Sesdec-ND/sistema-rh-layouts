@extends('layouts.admin')

@section('title', 'Relatórios - RH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Relatórios</h1>
            <p class="text-gray-600 mt-2">Gerencie e visualize relatórios do sistema</p>
        </div>
    </div>

    <!-- Cards de Relatórios Disponíveis -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Relatório de Colaboradores -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Disponível</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Relatório de Colaboradores</h3>
            <p class="text-gray-600 text-sm mb-4">Lista completa de todos os colaboradores com informações detalhadas</p>
            <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                <span><i class="fas fa-calendar mr-1"></i>Atualizado hoje</span>
                <span>PDF, Excel</span>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.relatorios.colaboradores') }}" 
                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-semibold transition duration-200 text-center">
                    <i class="fas fa-eye mr-1"></i>Visualizar
                </a>
                <a href="{{ route('admin.relatorios.colaboradores') }}?download=1" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg text-sm font-semibold transition duration-200">
                    <i class="fas fa-download"></i>
                </a>
            </div>
        </div>

        <!-- Relatório de Folha de Pagamento -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-file-invoice-dollar text-green-600 text-xl"></i>
                </div>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Disponível</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Folha de Pagamento</h3>
            <p class="text-gray-600 text-sm mb-4">Relatório mensal de folha de pagamento e benefícios</p>
            <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                <span><i class="fas fa-calendar mr-1"></i>{{ now()->format('m/Y') }}</span>
                <span>PDF, Excel</span>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.relatorios.folha-pagamento') }}" 
                   class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm font-semibold transition duration-200 text-center">
                    <i class="fas fa-eye mr-1"></i>Visualizar
                </a>
                <a href="{{ route('admin.relatorios.folha-pagamento') }}?download=1" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg text-sm font-semibold transition duration-200">
                    <i class="fas fa-download"></i>
                </a>
            </div>
        </div>

        <!-- Relatório de Performance -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-purple-100 p-3 rounded-lg">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Disponível</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Performance</h3>
            <p class="text-gray-600 text-sm mb-4">Métricas de performance e produtividade dos colaboradores</p>
            <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                <span><i class="fas fa-calendar mr-1"></i>Trimestral</span>
                <span>PDF, Excel</span>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.relatorios.performance') }}" 
                   class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg text-sm font-semibold transition duration-200 text-center">
                    <i class="fas fa-eye mr-1"></i>Visualizar
                </a>
                <a href="{{ route('admin.relatorios.performance') }}?download=1" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg text-sm font-semibold transition duration-200">
                    <i class="fas fa-download"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Acesso Rápido aos Relatórios Gerados -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Relatórios Gerados Recentemente</h2>
            <a href="{{ route('admin.relatorios.gerados') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                Ver Todos <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="space-y-4">
            @foreach([1, 2] as $relatorio)
            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-file-pdf text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Relatório de Colaboradores</h3>
                        <p class="text-gray-600 text-sm">Gerado em {{ now()->subHours(2)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">
                        PDF - 2.4 MB
                    </span>
                    <button class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-lg transition duration-200">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection