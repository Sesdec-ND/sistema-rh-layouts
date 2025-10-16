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
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Novo Relatório
        </button>
    </div>

    <!-- Cards de Relatórios -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Relatório de Colaboradores -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Ativo</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Relatório de Colaboradores</h3>
            <p class="text-gray-600 text-sm mb-4">Lista completa de todos os colaboradores com informações detalhadas</p>
            <div class="flex justify-between items-center text-sm text-gray-500">
                <span><i class="fas fa-calendar mr-1"></i>Atualizado hoje</span>
                <span>PDF, Excel</span>
            </div>
            <div class="mt-4 flex space-x-2">
                <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-semibold transition duration-200">
                    <i class="fas fa-download mr-1"></i>Baixar
                </button>
                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg text-sm font-semibold transition duration-200">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <!-- Relatório de Folha de Pagamento -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-file-invoice-dollar text-green-600 text-xl"></i>
                </div>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Ativo</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Folha de Pagamento</h3>
            <p class="text-gray-600 text-sm mb-4">Relatório mensal de folha de pagamento e benefícios</p>
            <div class="flex justify-between items-center text-sm text-gray-500">
                <span><i class="fas fa-calendar mr-1"></i>Dezembro 2024</span>
                <span>PDF, Excel</span>
            </div>
            <div class="mt-4 flex space-x-2">
                <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm font-semibold transition duration-200">
                    <i class="fas fa-download mr-1"></i>Baixar
                </button>
                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg text-sm font-semibold transition duration-200">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <!-- Relatório de Performance -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-purple-100 p-3 rounded-lg">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Pendente</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Performance</h3>
            <p class="text-gray-600 text-sm mb-4">Métricas de performance e produtividade dos colaboradores</p>
            <div class="flex justify-between items-center text-sm text-gray-500">
                <span><i class="fas fa-calendar mr-1"></i>Trimestral</span>
                <span>PDF, Excel</span>
            </div>
            <div class="mt-4 flex space-x-2">
                <button class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg text-sm font-semibold transition duration-200">
                    <i class="fas fa-download mr-1"></i>Baixar
                </button>
                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg text-sm font-semibold transition duration-200">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Tabela de Relatórios Gerados -->
    <div class="bg-white rounded-xl shadow-md">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Relatórios Gerados Recentemente</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Relatório
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Gerado em
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tamanho
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <i class="fas fa-users text-blue-600"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="font-semibold text-gray-900">Colaboradores Ativos</div>
                                    <div class="text-sm text-gray-500">Lista completa</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">
                                PDF
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            15/12/2024 14:30
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            2.4 MB
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                Concluído
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-lg transition duration-200"
                                        title="Download">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="bg-green-100 hover:bg-green-200 text-green-600 p-2 rounded-lg transition duration-200"
                                        title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition duration-200"
                                        title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="bg-green-100 p-2 rounded-lg">
                                    <i class="fas fa-file-invoice-dollar text-green-600"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="font-semibold text-gray-900">Folha de Pagamento</div>
                                    <div class="text-sm text-gray-500">Novembro 2024</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">
                                Excel
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            10/12/2024 09:15
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            1.8 MB
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                Concluído
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-lg transition duration-200"
                                        title="Download">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="bg-green-100 hover:bg-green-200 text-green-600 p-2 rounded-lg transition duration-200"
                                        title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition duration-200"
                                        title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection