<<<<<<< HEAD
{{-- resources/views/servidores/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gerenciar Servidores')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gerenciar Servidores</h1>
            <p class="text-gray-600 mt-2">Total de colaboradores: {{ $servidores->total() }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('servidores.trashed') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200 flex items-center">
                <i class="fas fa-trash-restore mr-2"></i>
                Lixeira
            </a>
            <a href="{{ route('servidores.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Novo Servidor
            </a>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6">
=======
{{-- No index dos servidores (resources/views/servidor/index.blade.php) --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <!-- Card Total Servidores -->
    <a href="{{ route('servidores.index') }}" class="block transform transition-transform hover:scale-105">
        <div class="bg-white rounded-xl shadow-md p-6 cursor-pointer hover:shadow-lg transition-shadow duration-200 border-2 border-transparent hover:border-blue-500">
>>>>>>> 068e35f (Cadastro servidores)
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Servidores</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $servidores->total() }}</p>
                </div>
            </div>
        </div>
<<<<<<< HEAD

        <div class="bg-white rounded-xl shadow-md p-6">
=======
    </a>

    <!-- Card Ativos -->
    <a href="{{ route('servidores.index') }}?status=ativo" class="block transform transition-transform hover:scale-105">
        <div class="bg-white rounded-xl shadow-md p-6 cursor-pointer hover:shadow-lg transition-shadow duration-200 border-2 border-transparent hover:border-green-500">
>>>>>>> 068e35f (Cadastro servidores)
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-user-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Ativos</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $servidores->total() }}</p>
                </div>
            </div>
        </div>
<<<<<<< HEAD

        <div class="bg-white rounded-xl shadow-md p-6">
=======
    </a>

    <!-- Card Efetivos -->
    <a href="{{ route('servidores.index') }}?vinculo=efetivo" class="block transform transition-transform hover:scale-105">
        <div class="bg-white rounded-xl shadow-md p-6 cursor-pointer hover:shadow-lg transition-shadow duration-200 border-2 border-transparent hover:border-orange-500">
>>>>>>> 068e35f (Cadastro servidores)
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                    <i class="fas fa-user-clock text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Efetivos</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ \App\Models\Servidor::where('id_vinculo', 'Efetivo')->count() }}
                    </p>
                </div>
            </div>
        </div>
<<<<<<< HEAD

        <div class="bg-white rounded-xl shadow-md p-6">
=======
    </a>

    <!-- Card Lotação PM -->
    <a href="{{ route('servidores.index') }}?lotacao=pm" class="block transform transition-transform hover:scale-105">
        <div class="bg-white rounded-xl shadow-md p-6 cursor-pointer hover:shadow-lg transition-shadow duration-200 border-2 border-transparent hover:border-purple-500">
>>>>>>> 068e35f (Cadastro servidores)
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <i class="fas fa-building text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Lotação PM</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ \App\Models\Servidor::where('id_lotacao', 'PM')->count() }}
                    </p>
                </div>
            </div>
        </div>
<<<<<<< HEAD
    </div>

    <!-- Tabela de Servidores -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Lista de Servidores</h2>
        </div>

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
                            Vínculo/Lotação
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contato
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $servidor->id_vinculo }}</div>
                            <div class="text-sm text-gray-500">{{ $servidor->id_lotacao }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $servidor->telefone }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('servidores.show', $servidor) }}" 
                                   class="text-blue-600 hover:text-blue-900" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('servidores.edit', $servidor) }}" 
                                   class="text-green-600 hover:text-green-900" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('servidores.destroy', $servidor) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900" 
                                            title="Excluir"
                                            onclick="return confirm('Tem certeza que deseja excluir este servidor?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Nenhum servidor cadastrado.
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
=======
    </a>
</div>
>>>>>>> 068e35f (Cadastro servidores)
