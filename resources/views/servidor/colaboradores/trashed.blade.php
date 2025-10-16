<<<<<<< HEAD
{{-- resources/views/servidores/trashed.blade.php --}}
=======
>>>>>>> 068e35f (Cadastro servidores)
@extends('layouts.app')

@section('title', 'Servidores Excluídos')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
<<<<<<< HEAD
            <h1 class="text-3xl font-bold text-gray-800">Servidores Excluídos</h1>
            <p class="text-gray-600 mt-2">Servidores removidos temporariamente</p>
        </div>
        <a href="{{ route('servidores.index') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
            Voltar para Lista
        </a>
=======
            <h1 class="text-3xl font-bold text-gray-800">Lixeira</h1>
            <p class="text-gray-600 mt-2">Servidores excluídos: {{ $servidores->total() }}</p>
        </div>
        <div>
            <a href="{{ route('servidores.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar para Servidores
            </a>
        </div>
>>>>>>> 068e35f (Cadastro servidores)
    </div>

    <!-- Tabela de Servidores Excluídos -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
<<<<<<< HEAD
=======
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Servidores na Lixeira</h2>
        </div>

>>>>>>> 068e35f (Cadastro servidores)
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
                            Excluído em
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($servidores as $servidor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
<<<<<<< HEAD
=======
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($servidor->foto)
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                             src="{{ Storage::disk('public')->url($servidor->foto) }}" 
                                             alt="{{ $servidor->nome_completo }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-600"></i>
                                        </div>
                                    @endif
                                </div>
>>>>>>> 068e35f (Cadastro servidores)
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $servidor->nome_completo }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $servidor->formacao }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Mat: {{ $servidor->matricula }}</div>
                            <div class="text-sm text-gray-500">CPF: {{ $servidor->cpf }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $servidor->deleted_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
<<<<<<< HEAD
                                <form action="{{ route('servidores.restore', $servidor->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" 
                                            class="text-green-600 hover:text-green-900"
                                            onclick="return confirm('Restaurar este servidor?')">
                                        <i class="fas fa-undo mr-1"></i> Restaurar
                                    </button>
                                </form>
                                <form action="{{ route('servidores.force-delete', $servidor->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Excluir permanentemente? Esta ação não pode ser desfeita!')">
                                        <i class="fas fa-trash mr-1"></i> Excluir Permanentemente
=======
                                <form action="{{ route('servidores.restore', $servidor) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="text-green-600 hover:text-green-900" 
                                            title="Restaurar">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>
                                <form action="{{ route('servidores.force-delete', $servidor) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900" 
                                            title="Excluir Permanentemente"
                                            onclick="return confirm('Tem certeza que deseja excluir permanentemente este servidor? Esta ação não pode ser desfeita.')">
                                        <i class="fas fa-times"></i>
>>>>>>> 068e35f (Cadastro servidores)
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            Nenhum servidor na lixeira.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $servidores->links() }}
        </div>
    </div>
</div>
@endsection