@extends('layouts.admin')

@section('title', 'Colaboradores - RH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gerenciar Colaboradores</h1>
            <p class="text-gray-600 mt-2">Gerencie todos os colaboradores do sistema</p>
        </div>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Novo Colaborador
        </button>
    </div>

    <!-- Filtros e Busca -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Buscar</label>
                <input type="text" 
                       placeholder="Nome, CPF, email..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Perfil</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos os perfis</option>
                    <option value="RH">RH</option>
                    <option value="Diretor Executivo">Diretor Executivo</option>
                    <option value="Colaborador">Colaborador</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                    <i class="fas fa-filter mr-2"></i>
                    Filtrar
                </button>
            </div>
        </div>
    </div>

    <!-- Tabela de Colaboradores -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Colaborador
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            CPF
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Perfil
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Email
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
                    @foreach($colaboradores as $colaborador)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="font-semibold text-gray-900">{{ $colaborador->name }}</div>
                                    <div class="text-sm text-gray-500">RG: {{ $colaborador->rg }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $colaborador->cpf }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $badgeColors = [
                                    'RH' => 'bg-purple-100 text-purple-800',
                                    'Diretor Executivo' => 'bg-yellow-100 text-yellow-800',
                                    'Colaborador' => 'bg-green-100 text-green-800'
                                ];
                                $color = $badgeColors[$colaborador->perfil->nomePerfil] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                {{ $colaborador->perfil->nomePerfil }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $colaborador->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-circle mr-1 text-xs"></i>
                                Ativo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-lg transition duration-200"
                                        title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="bg-green-100 hover:bg-green-200 text-green-600 p-2 rounded-lg transition duration-200"
                                        title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition duration-200"
                                        title="Desativar">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Mostrando <span class="font-semibold">1</span> a <span class="font-semibold">{{ count($colaboradores) }}</span> de <span class="font-semibold">{{ count($colaboradores) }}</span> resultados
                </div>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Anterior
                    </button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Próxima
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection