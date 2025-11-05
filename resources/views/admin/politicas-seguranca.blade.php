@extends('layouts.admin')

@section('title', 'Políticas de Segurança - RH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Políticas de Segurança</h1>
            <p class="text-gray-600 mt-2">Configure as políticas de segurança e acesso do sistema</p>
        </div>
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg">
            <i class="fas fa-shield-alt mr-2"></i>
            Sistema Protegido
        </div>
    </div>

    <!-- Cards de Status de Segurança -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Segurança</p>
                    <p class="text-2xl font-bold text-gray-800">Alta</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-lock text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-green-600">
                <i class="fas fa-check-circle mr-1"></i>
                Todas as políticas ativas
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Tentativas de Login</p>
                    <p class="text-2xl font-bold text-gray-800">0</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-sign-in-alt text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <i class="fas fa-user-shield mr-1"></i>
                Nenhuma tentativa suspeita
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Última Auditoria</p>
                    <p class="text-2xl font-bold text-gray-800">Hoje</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-clipboard-check text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <i class="fas fa-clock mr-1"></i>
                Sem problemas encontrados
            </div>
        </div>
    </div>

    <form action="{{ route('admin.seguranca.politicas') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Políticas de Senha -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center mb-6">
                    <div class="bg-red-100 p-3 rounded-full mr-4">
                        <i class="fas fa-key text-red-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Políticas de Senha</h2>
                        <p class="text-gray-600">Configure os requisitos para senhas seguras</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tamanho Mínimo da Senha</label>
                        <input type="number" name="tamanho_minimo_senha" 
                               value="{{ $politicas['tamanho_minimo_senha'] ?? 8 }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               min="6" max="20">
                        <p class="text-sm text-gray-500 mt-1">Recomendado: 8 caracteres ou mais</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Exigir letras maiúsculas</label>
                                <p class="text-sm text-gray-500">Pelo menos uma letra maiúscula (A-Z)</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="exigir_maiusculas" 
                                       {{ ($politicas['exigir_maiusculas'] ?? true) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Exigir números</label>
                                <p class="text-sm text-gray-500">Pelo menos um número (0-9)</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="exigir_numeros" 
                                       {{ ($politicas['exigir_numeros'] ?? true) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Exigir caracteres especiais</label>
                                <p class="text-sm text-gray-500">Pelo menos um caractere especial (!@#$%)</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="exigir_especiais" 
                                       {{ ($politicas['exigir_especiais'] ?? false) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Políticas de Login -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center mb-6">
                    <div class="bg-orange-100 p-3 rounded-full mr-4">
                        <i class="fas fa-user-lock text-orange-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Controle de Acesso</h2>
                        <p class="text-gray-600">Configurações de login e sessão</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Máximo de Tentativas de Login</label>
                        <input type="number" name="max_tentativas_login" 
                               value="{{ $politicas['max_tentativas_login'] ?? 5 }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               min="1" max="10">
                        <p class="text-sm text-gray-500 mt-1">Número de tentativas antes do bloqueio</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tempo de Bloqueio (minutos)</label>
                        <input type="number" name="bloqueio_tempo_minutos" 
                               value="{{ $politicas['bloqueio_tempo_minutos'] ?? 30 }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               min="1" max="1440">
                        <p class="text-sm text-gray-500 mt-1">Duração do bloqueio após tentativas excessivas</p>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Login com Dois Fatores (2FA)</label>
                            <p class="text-sm text-gray-500">Requer autenticação adicional</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="login_dois_fatores" 
                                   {{ ($politicas['login_dois_fatores'] ?? false) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações -->
        <div class="bg-white rounded-xl shadow-md p-6 mt-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Aplicar Políticas de Segurança</h3>
                    <p class="text-gray-600">As alterações afetarão todos os usuários do sistema</p>
                </div>
                <div class="flex space-x-3">
                    <button type="button" 
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 flex items-center">
                        <i class="fas fa-redo mr-2"></i>
                        Restaurar Padrões
                    </button>
                    <button type="submit" 
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 flex items-center">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Aplicar Políticas
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Dicas de Segurança -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="bg-blue-100 p-3 rounded-full mr-4">
                <i class="fas fa-lightbulb text-blue-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-blue-800 mb-2">Melhores Práticas de Segurança</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-blue-700">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-1 text-green-500"></i>
                        <span>Senhas com pelo menos 8 caracteres misturam letras, números e símbolos</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-1 text-green-500"></i>
                        <span>Bloqueio após 5 tentativas falhas previne ataques de força bruta</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-1 text-green-500"></i>
                        <span>2FA adiciona uma camada extra de proteção para contas administrativas</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle mr-2 mt-1 text-green-500"></i>
                        <span>Auditoria regular ajuda a identificar atividades suspeitas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection