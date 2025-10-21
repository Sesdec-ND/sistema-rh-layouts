@extends('layouts.app')

@section('title', 'Meu Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header Pessoal -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 p-4 rounded-full">
                    <i class="fas fa-user text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Olá, {{ $user->name }}!</h1>
                    <p class="text-gray-600">Bem-vindo ao seu painel pessoal</p>
                </div>
            </div>
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                <i class="fas fa-user-clock mr-2"></i>
                Colaborador
            </div>
        </div>
    </div>

    <!-- Informações Pessoais Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-id-card text-blue-600 text-xl"></i>
                </div>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Ativo</span>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2">Dados Pessoais</h3>
            <p class="text-sm text-gray-600 mb-4">Suas informações cadastrais</p>
            <a href="{{ route('colaborador.perfil') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200 inline-block">
                <i class="fas fa-eye mr-1"></i>Ver Perfil
            </a>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                </div>
                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Atualizado</span>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2">Próximos Eventos</h3>
            <p class="text-sm text-gray-600 mb-2">
                <i class="fas fa-birthday-cake text-purple-500 mr-2"></i>
                Aniversário: 15/03
            </p>
            <p class="text-sm text-gray-600">
                <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                Reunião: 20/12
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Em Andamento</span>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2">Meu Desempenho</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span>Meta Trimestral</span>
                    <span class="font-semibold">85%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 85%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Ações Disponíveis</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('colaborador.perfil') }}" 
               class="bg-blue-50 hover:bg-blue-100 border border-blue-200 p-4 rounded-lg transition duration-200 text-center group">
                <div class="bg-blue-100 p-3 rounded-full inline-block group-hover:bg-blue-200 transition duration-200">
                    <i class="fas fa-user-edit text-blue-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mt-2">Meu Perfil</h3>
                <p class="text-sm text-gray-600">Visualizar e atualizar</p>
            </a>

            <div class="bg-green-50 hover:bg-green-100 border border-green-200 p-4 rounded-lg transition duration-200 text-center group cursor-pointer">
                <div class="bg-green-100 p-3 rounded-full inline-block group-hover:bg-green-200 transition duration-200">
                    <i class="fas fa-file-contract text-green-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mt-2">Documentos</h3>
                <p class="text-sm text-gray-600">Acessar meus docs</p>
            </div>

            <div class="bg-purple-50 hover:bg-purple-100 border border-purple-200 p-4 rounded-lg transition duration-200 text-center group cursor-pointer">
                <div class="bg-purple-100 p-3 rounded-full inline-block group-hover:bg-purple-200 transition duration-200">
                    <i class="fas fa-calendar-day text-purple-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mt-2">Ponto</h3>
                <p class="text-sm text-gray-600">Registro de horas</p>
            </div>

            <div class="bg-yellow-50 hover:bg-yellow-100 border border-yellow-200 p-4 rounded-lg transition duration-200 text-center group cursor-pointer">
                <div class="bg-yellow-100 p-3 rounded-full inline-block group-hover:bg-yellow-200 transition duration-200">
                    <i class="fas fa-question-circle text-yellow-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mt-2">Ajuda</h3>
                <p class="text-sm text-gray-600">Suporte e FAQ</p>
            </div>
        </div>
    </div>

    <!-- Informações Recentes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Notícias da Empresa -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-newspaper mr-2 text-blue-600"></i>
                Notícias da Empresa
            </h2>
            <div class="space-y-4">
                <div class="border-l-4 border-green-500 pl-4 py-2">
                    <h3 class="font-semibold text-gray-800">Festa de Final de Ano</h3>
                    <p class="text-sm text-gray-600">Confirmada para 20/12 no espaço empresa</p>
                    <span class="text-xs text-gray-500">Publicado: 01/12/2024</span>
                </div>
                <div class="border-l-4 border-blue-500 pl-4 py-2">
                    <h3 class="font-semibold text-gray-800">Novo Benefício</h3>
                    <p class="text-sm text-gray-600">Plano de saúde ampliado a partir de Janeiro</p>
                    <span class="text-xs text-gray-500">Publicado: 25/11/2024</span>
                </div>
            </div>
        </div>

        <!-- Meus Contatos -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-address-book mr-2 text-purple-600"></i>
                Contatos Importantes
            </h2>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-2 rounded-full">
                            <i class="fas fa-user-tie text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-gray-800">Departamento de RH</p>
                            <p class="text-sm text-gray-600">rh@empresa.com</p>
                        </div>
                    </div>
                    <button class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-lg">
                        <i class="fas fa-envelope"></i>
                    </button>
                </div>
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-2 rounded-full">
                            <i class="fas fa-headset text-green-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-gray-800">Suporte TI</p>
                            <p class="text-sm text-gray-600">suporte@empresa.com</p>
                        </div>
                    </div>
                    <button class="bg-green-100 hover:bg-green-200 text-green-600 p-2 rounded-lg">
                        <i class="fas fa-envelope"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Lembretes -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="bg-yellow-100 p-2 rounded-full mr-4">
                <i class="fas fa-bell text-yellow-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-yellow-800 text-lg mb-2">Lembretes</h3>
                <ul class="text-yellow-700 list-disc list-inside space-y-1">
                    <li>Atualize seus dados bancários até 05/12</li>
                    <li>Feedback trimestral agendado para 15/12</li>
                    <li>Entrega do uniforme novo na portaria</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection