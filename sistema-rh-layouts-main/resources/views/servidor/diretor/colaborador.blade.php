@extends('layouts.app')

@section('title', 'Colaboradores - Diretor')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Colaboradores</h1>
            <p class="text-gray-600 mt-2">Visualização de todos os colaboradores (Modo Leitura)</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-eye mr-2"></i>
                Somente Visualização
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Buscar Colaborador</label>
                <input type="text" 
                       placeholder="Nome, departamento..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Departamento</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos os departamentos</option>
                    <option value="TI">Tecnologia da Informação</option>
                    <option value="RH">Recursos Humanos</option>
                    <option value="Vendas">Vendas</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Financeiro">Financeiro</option>
                    <option value="Operações">Operações</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Buscar
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
                            Departamento
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Cargo
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Perfil de Acesso
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
                                    <div class="text-sm text-gray-500">{{ $colaborador->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $departamentos = ['TI', 'RH', 'Vendas', 'Marketing', 'Financeiro', 'Operações'];
                                $depto = $departamentos[array_rand($departamentos)];
                                $deptoColors = [
                                    'TI' => 'bg-purple-100 text-purple-800',
                                    'RH' => 'bg-pink-100 text-pink-800',
                                    'Vendas' => 'bg-blue-100 text-blue-800',
                                    'Marketing' => 'bg-green-100 text-green-800',
                                    'Financeiro' => 'bg-yellow-100 text-yellow-800',
                                    'Operações' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $deptoColors[$depto] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $depto }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @php
                                    $cargos = [
                                        'Desenvolvedor', 'Analista de RH', 'Vendedor', 
                                        'Gerente', 'Coordenador', 'Assistente'
                                    ];
                                @endphp
                                {{ $cargos[array_rand($cargos)] }}
                            </div>
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
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-circle mr-1 text-xs"></i>
                                Ativo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-lg transition duration-200"
                                        title="Visualizar Detalhes">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="bg-gray-100 text-gray-400 p-2 rounded-lg cursor-not-allowed"
                                        title="Edição não permitida"
                                        disabled>
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="bg-gray-100 text-gray-400 p-2 rounded-lg cursor-not-allowed"
                                        title="Ação não permitida"
                                        disabled>
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Informação de Visualização -->
        <div class="bg-blue-50 border-t border-blue-200 px-6 py-4">
            <div class="flex items-center text-blue-700">
                <i class="fas fa-info-circle mr-2"></i>
                <span class="text-sm">
                    Modo de visualização - Para edições, entre em contato com o departamento de RH
                </span>
            </div>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-md text-center">
            <div class="text-2xl font-bold text-blue-600">{{ count($colaboradores) }}</div>
            <div class="text-sm text-gray-600">Total Colaboradores</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md text-center">
            <div class="text-2xl font-bold text-green-600">{{ count($colaboradores) - 2 }}</div>
            <div class="text-sm text-gray-600">Ativos</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md text-center">
            <div class="text-2xl font-bold text-yellow-600">6</div>
            <div class="text-sm text-gray-600">Departamentos</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md text-center">
            <div class="text-2xl font-bold text-purple-600">78%</div>
            <div class="text-sm text-gray-600">Satisfação</div>
        </div>
    </div>
</div>
@endsection