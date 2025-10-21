{{-- [file name]: acesso-sistema.blade.php --}}
@extends('layouts.admin')

@section('title', 'Acesso ao Sistema - RH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Acesso ao Sistema</h1>
            <p class="text-gray-600 mt-2">Gerencie o acesso dos colaboradores ao sistema</p>
        </div>
        <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
            <i class="fas fa-key mr-2"></i>
            Controle de Acesso
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
            <p class="font-bold">Sucesso!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Cards de Resumo -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Colaboradores</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $servidores->count() }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Com Acesso</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $servidores->where('user', '!=', null)->count() }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-user-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Sem Acesso</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $servidores->where('user', null)->count() }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-user-plus text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Acesso -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Controle de Acesso</h2>
            <p class="text-gray-600 mt-1">Gerencie quais colaboradores têm acesso ao sistema</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Colaborador</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acesso Sistema</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perfil Atual</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($servidores as $servidor)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $servidor->nome_completo }}</div>
                                    <div class="text-sm text-gray-500">{{ $servidor->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $servidor->cpf }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Ativo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($servidor->user)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Ativo
                                </span>
                                <div class="text-xs text-gray-500 mt-1">Desde: {{ $servidor->user->created_at->format('d/m/Y') }}</div>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Sem Acesso
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($servidor->user)
                                @php
                                    $badgeColors = [
                                        'RH' => 'bg-purple-100 text-purple-800',
                                        'Diretor Executivo' => 'bg-yellow-100 text-yellow-800',
                                        'Colaborador' => 'bg-green-100 text-green-800',
                                    ];
                                    $color = $badgeColors[$servidor->user->perfil->nomePerfil] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                    {{ $servidor->user->perfil->nomePerfil }}
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                    Não definido
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                @if($servidor->user)
                                    <a href="{{ route('admin.acesso-sistema.atribuir', $servidor->id) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                                        <i class="fas fa-edit mr-2"></i>
                                        Alterar Perfil
                                    </a>
                                    <form action="{{ route('admin.acesso-sistema.revogar', $servidor->user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center"
                                                onclick="return confirm('Tem certeza que deseja revogar o acesso deste usuário?')">
                                            <i class="fas fa-ban mr-2"></i>
                                            Revogar Acesso
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.acesso-sistema.atribuir', $servidor->id) }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        Atribuir Acesso
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection