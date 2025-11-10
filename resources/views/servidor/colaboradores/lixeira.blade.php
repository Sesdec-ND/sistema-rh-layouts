@extends('layouts.admin')

@section('title', 'Lixeira - Servidores')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Lixeira</h1>
            <p class="text-gray-600 mt-2">Servidores excluídos: {{ $servidores->total() }}</p>
        </div>
        <div class="flex space-x-3">
            @if($servidores->count() > 0)
            <form action="{{ route('servidores.empty-trash') }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200 flex items-center"
                        onclick="return confirm('Tem certeza que deseja esvaziar toda a lixeira? Esta ação não pode ser desfeita.')">
                    <i class="fas fa-trash mr-2"></i>
                    Esvaziar Lixeira
                </button>
            </form>
            @endif
            <a href="{{ route('admin.colaborador') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar para Servidores
            </a>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Sucesso!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Erro!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Tabela de Servidores Excluídos -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-800">Servidores na Lixeira</h2>
            <p class="text-sm text-gray-600 mt-1">Itens excluídos ficam disponíveis para restauração</p>
        </div>

        @if($servidores->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Servidor
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Matrícula/CPF
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Lotação
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Excluído em
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($servidores as $servidor)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($servidor->foto)
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                             src="{{ $servidor->foto_url }}" 
                                             alt="{{ $servidor->nome_completo }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-600"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $servidor->nome_completo }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $servidor->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Mat: {{ $servidor->matricula }}</div>
                            <div class="text-sm text-gray-500">CPF: {{ $servidor->formatted_cpf }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $servidor->lotacao->sigla ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-gray-400 mr-2"></i>
                                {{ $servidor->deleted_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="text-xs text-gray-400">
                                {{ $servidor->deleted_at->diffForHumans() }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <!-- Botão Restaurar -->
                                <form action="{{ route('servidores.restore', $servidor->matricula) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="bg-green-100 hover:bg-green-200 text-green-600 p-2 rounded-lg transition duration-200"
                                            title="Restaurar Servidor">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>

                                <!-- Botão Excluir Permanentemente -->
                                <form action="{{ route('servidores.force-delete', $servidor->matricula) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition duration-200"
                                            title="Excluir Permanentemente"
                                            onclick="return confirm('Tem certeza que deseja excluir permanentemente {{ $servidor->nome_completo }}? Esta ação não pode ser desfeita.')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        @if($servidores->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Mostrando <span class="font-semibold">{{ $servidores->firstItem() }}</span> a 
                    <span class="font-semibold">{{ $servidores->lastItem() }}</span> de 
                    <span class="font-semibold">{{ $servidores->total() }}</span> resultados
                </div>
                <div>
                    {{ $servidores->links() }}
                </div>
            </div>
        </div>
        @endif
        @else
        <!-- Estado vazio -->
        <div class="text-center py-12">
            <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-trash text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Lixeira vazia</h3>
            <p class="text-gray-600 mb-6">Não há servidores excluídos no momento.</p>
            <a href="{{ route('admin.colaborador') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-200 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar para Servidores
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

