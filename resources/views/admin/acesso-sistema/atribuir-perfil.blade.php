@extends('layouts.admin')

@section('title', 'Atribuir Perfil de Acesso - RH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Atribuir Perfil de Acesso</h1>
            <p class="text-gray-600 mt-2">Configure o acesso do colaborador ao sistema</p>
        </div>
        <a href="{{ route('admin.acesso-sistema') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Voltar
        </a>
    </div>

    <!-- Informações do Colaborador -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Informações do Colaborador</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <label class="block text-sm font-semibold text-blue-700 mb-1">Nome Completo</label>
                <p class="text-lg font-bold text-gray-900">{{ $servidor->nome_completo }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <label class="block text-sm font-semibold text-green-700 mb-1">CPF (Login)</label>
                <p class="text-lg font-bold text-gray-900">{{ $servidor->cpf }}</p>
                <p class="text-xs text-green-600 mt-1">Este será o usuário para login</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
                <label class="block text-sm font-semibold text-purple-700 mb-1">Matrícula</label>
                <p class="text-lg font-bold text-gray-900">{{ $servidor->matricula }}</p>
            </div>
            <div class="bg-yellow-50 p-4 rounded-lg">
                <label class="block text-sm font-semibold text-yellow-700 mb-1">RG</label>
                <p class="text-lg font-bold text-gray-900">{{ $servidor->rg ?? 'Não informado' }}</p>
            </div>
            <div class="bg-red-50 p-4 rounded-lg">
                <label class="block text-sm font-semibold text-red-700 mb-1">Lotação</label>
                <p class="text-lg font-bold text-gray-900">{{ $servidor->id_lotacao ?? 'Não informada' }}</p>
            </div>
            <div class="bg-indigo-50 p-4 rounded-lg">
                <label class="block text-sm font-semibold text-indigo-700 mb-1">Email</label>
                <p class="text-lg font-bold text-gray-900">{{ $servidor->email ?? 'Não informado' }}</p>
            </div>
        </div>
    </div>

    @if($usuarioExistente)
        <!-- Editar Perfil Existente -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
            <div class="flex items-center mb-4">
                <div class="bg-yellow-100 p-3 rounded-full mr-4">
                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-yellow-800">Usuário Já Existente</h3>
                    <p class="text-yellow-700">Este colaborador já possui acesso ao sistema.</p>
                </div>
            </div>
            
            <form action="{{ route('admin.acesso-sistema.atualizar-perfil', $usuarioExistente->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Perfil de Acesso *</label>
                        <select name="perfil_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Selecione o perfil...</option>
                            @foreach($perfis as $perfil)
                                <option value="{{ $perfil->id }}" 
                                    {{ $usuarioExistente->perfil_id == $perfil->id ? 'selected' : '' }}>
                                    {{ $perfil->nomePerfil }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Atualizar Perfil
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @else
        <!-- Criar Novo Usuário -->
        <form action="{{ route('admin.acesso-sistema.criar-usuario', $servidor->id) }}" method="POST" class="bg-white rounded-xl shadow-md p-6">
            @csrf
            
            <h2 class="text-xl font-bold text-gray-800 mb-6">Criar Acesso ao Sistema</h2>
            
            <!-- Informações de Login -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-center mb-2">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    <h3 class="text-lg font-semibold text-blue-800">Informações de Login</h3>
                </div>
                <p class="text-sm text-blue-700">
                    O colaborador usará o <strong>CPF</strong> como usuário para fazer login no sistema.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Dados de Acesso -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-1 text-blue-600"></i>
                        Email *
                    </label>
                    <input type="email" name="email" value="{{ old('email', $servidor->email) }}" required
                           placeholder="email@dominio.com"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Para recuperação de senha e notificações</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user mr-1 text-green-600"></i>
                        Nome de Usuário *
                    </label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                           placeholder="nome.usuario"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror">
                    @error('username')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Identificação interna no sistema</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1 text-red-600"></i>
                        Senha *
                    </label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                           placeholder="Mínimo 8 caracteres">
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1 text-red-600"></i>
                        Confirmar Senha *
                    </label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Digite a senha novamente">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user-tag mr-1 text-purple-600"></i>
                        Perfil de Acesso *
                    </label>
                    <select name="perfil_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('perfil_id') border-red-500 @enderror">
                        <option value="">Selecione o perfil...</option>
                        @foreach($perfis as $perfil)
                            <option value="{{ $perfil->id }}" {{ old('perfil_id') == $perfil->id ? 'selected' : '' }}>
                                {{ $perfil->nomePerfil }} - {{ $perfil->descricao }}
                            </option>
                        @endforeach
                    </select>
                    @error('perfil_id')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Defina as permissões do usuário no sistema</p>
                </div>
            </div>

            <!-- Resumo do Acesso -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-6">
                <h3 class="text-lg font-semibold text-green-800 mb-2">Resumo do Acesso</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-semibold text-green-700">Usuário para login:</span>
                        <span class="ml-2 font-mono bg-green-100 px-2 py-1 rounded">{{ $servidor->cpf }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-green-700">Nome no sistema:</span>
                        <span class="ml-2">{{ $servidor->nome_completo }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Botões -->
            <div class="flex justify-end space-x-4 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.acesso-sistema') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-200">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Criar Acesso
                </button>
            </div>
        </form>
    @endif
</div>
@endsection