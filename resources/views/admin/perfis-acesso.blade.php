@extends('layouts.admin')

@section('title', 'Perfis de Acesso - RH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Perfis de Acesso</h1>
            <p class="text-gray-600 mt-2">Gerencie os perfis e permissões do sistema</p>
        </div>
        <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
            <i class="fas fa-user-shield mr-2"></i>
            {{ $perfis->count() }} Perfis Configurados
        </div>
    </div>

    <!-- Cards de Resumo -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total de Perfis</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $perfis->count() }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users-cog text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-green-600">
                <i class="fas fa-check-circle mr-1"></i>
                Todos ativos
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Permissões Totais</p>
                    <p class="text-3xl font-bold text-gray-800">24</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-key text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <i class="fas fa-lock mr-1"></i>
                Sistema seguro
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Última Atualização</p>
                    <p class="text-2xl font-bold text-gray-800">Hoje</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-sync-alt text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <i class="fas fa-clock mr-1"></i>
                Atualizado recentemente
            </div>
        </div>
    </div>

    <!-- Lista de Perfis -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Lista de Perfis do Sistema</h2>
            <p class="text-gray-600 mt-1">Gerencie as permissões de cada perfil de usuário</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perfil</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissões Ativas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($perfis as $perfil)
                    @php
                        $permissoes = json_decode($perfil->permissoes, true);
                        $totalPermissoes = count(array_filter($permissoes, function($value) {
                            return $value !== false && $value !== null;
                        }));
                    @endphp
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-tag text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $perfil->nomePerfil }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $perfil->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $perfil->descricao }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $totalPermissoes }} permissões
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.perfis-acesso', $perfil->id) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                                    <i class="fas fa-edit mr-2"></i>
                                    Editar
                                </a>
                                <a href="{{ route('admin.perfis-acesso', $perfil->id) }}" 
                                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                                    <i class="fas fa-key mr-2"></i>
                                    Permissões
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-600">
                    Mostrando <span class="font-medium">{{ $perfis->count() }}</span> perfis
                </p>
                <div class="text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-1"></i>
                    Clique em "Permissões" para gerenciar acesso detalhado
                </div>
            </div>
        </div>
    </div>

    <!-- Ajuda Rápida -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="bg-blue-100 p-3 rounded-full mr-4">
                <i class="fas fa-question-circle text-blue-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-blue-800 mb-2">Como gerenciar perfis?</h3>
                <ul class="text-blue-700 space-y-1">
                    <li><i class="fas fa-check-circle mr-2 text-green-500"></i>Use "Editar" para modificar nome e descrição</li>
                    <li><i class="fas fa-check-circle mr-2 text-green-500"></i>Use "Permissões" para configurar acesso aos módulos</li>
                    <li><i class="fas fa-check-circle mr-2 text-green-500"></i>O perfil RH tem acesso completo ao sistema</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection