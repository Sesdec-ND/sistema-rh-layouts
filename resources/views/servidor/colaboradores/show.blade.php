{{-- resources/views/servidores/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Visualizar Servidor - ' . $servidor->nome_completo)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $servidor->nome_completo }}</h1>
            <p class="text-gray-600 mt-2">Matrícula: {{ $servidor->matricula }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('servidores.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-semibold transition duration-200">
                Voltar
            </a>
            <a href="{{ route('servidores.edit', $servidor) }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200 flex items-center">
                <i class="fas fa-edit mr-2"></i>
                Editar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Coluna Esquerda - Foto e Info Básica -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="text-center">
                    @if($servidor->foto)
                        <img class="h-32 w-32 rounded-full mx-auto object-cover mb-4" 
                             src="{{ Storage::disk('public')->url($servidor->foto) }}" 
                             alt="{{ $servidor->nome_completo }}">
                    @else
                        <div class="h-32 w-32 rounded-full bg-gray-300 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user text-gray-600 text-4xl"></i>
                        </div>
                    @endif
                    <h2 class="text-xl font-bold text-gray-800">{{ $servidor->nome_completo }}</h2>
                    <p class="text-gray-600">{{ $servidor->formacao }}</p>
                </div>

                <div class="mt-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Matrícula</label>
                        <p class="text-gray-900">{{ $servidor->matricula }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">CPF</label>
                        <p class="text-gray-900">{{ $servidor->cpf }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">RG</label>
                        <p class="text-gray-900">{{ $servidor->rg }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Direita - Dados Detalhados -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Dados Pessoais -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">Dados Pessoais</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Data de Nascimento</label>
                        <p class="text-gray-900">{{ $servidor->data_nascimento->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Gênero</label>
                        <p class="text-gray-900">{{ $servidor->genero }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Estado Civil</label>
                        <p class="text-gray-900">{{ $servidor->estado_civil }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Raça/Cor</label>
                        <p class="text-gray-900">{{ $servidor->raca_cor }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Tipo Sanguíneo</label>
                        <p class="text-gray-900">{{ $servidor->tipo_sanguineo }}</p>
                    </div>
                </div>
            </div>

            <!-- Dados de Contato -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">Contato</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Telefone</label>
                        <p class="text-gray-900">{{ $servidor->telefone }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Endereço</label>
                        <p class="text-gray-900">{{ $servidor->endereco }}</p>
                    </div>
                </div>
            </div>

            <!-- Dados Funcionais -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">Dados Funcionais</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">PIS/PASEP</label>
                        <p class="text-gray-900">{{ $servidor->pis_pasep }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Data de Nomeação</label>
                        <p class="text-gray-900">{{ $servidor->data_nomeacao->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Vínculo</label>
                        <p class="text-gray-900">{{ $servidor->id_vinculo }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Lotação</label>
                        <p class="text-gray-900">{{ $servidor->id_lotacao }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection