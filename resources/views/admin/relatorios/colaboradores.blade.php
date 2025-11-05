@extends('layouts.admin') {{-- Corrigido de layouts.admin para admin --}}

@section('title', 'Relatório de Colaboradores - RH')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Relatório de Colaboradores</h1>
                <p class="text-gray-600 mt-2">Relatório detalhado dos colaboradores do sistema</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.relatorios.colaboradores') }}?download=1"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    Baixar PDF
                </a>
                <a href="{{ route('admin.relatorios.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>
            </div>
        </div>

        <!-- Informações do Relatório -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-blue-600 font-semibold">Total de Colaboradores</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $estatisticas['total_colaboradores'] ?? 0 }}</div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-green-600 font-semibold">Ativos</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $estatisticas['total_ativos'] ?? 0 }}</div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <div class="text-purple-600 font-semibold">Data de Geração</div>
                    <div class="text-lg font-semibold text-gray-800">{{ $data_geracao ?? now()->format('d/m/Y H:i') }}</div>
                </div>
                <div class="bg-orange-50 p-4 rounded-lg">
                    <div class="text-orange-600 font-semibold">Gerado por</div>
                    <div class="text-lg font-semibold text-gray-800">{{ $usuario_gerador ?? 'Sistema' }}</div>
                </div>
            </div>

            <!-- Filtros Aplicados -->
            @if (!empty(array_filter($filtros_aplicados ?? [])))
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Filtros Aplicados</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($filtros_aplicados as $filtro => $valor)
                            @if ($valor)
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                    {{ $filtro }}: {{ $valor }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Estatísticas Detalhadas -->
            <div class="mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">{{ $estatisticas['total_masculino'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Masculino</div>
                </div>
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="text-2xl font-bold text-pink-600">{{ $estatisticas['total_feminino'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Feminino</div>
                </div>
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ $estatisticas['media_idade'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Idade Média</div>
                </div>
                <div class="text-center p-4 border border-gray-200 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600">{{ count($colaboradores ?? []) }}</div>
                    <div class="text-sm text-gray-600">Resultados</div>
                </div>
            </div>

            <!-- Tabela de Colaboradores -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nome</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Matrícula</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Lotação</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Vínculo</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($colaboradores ?? [] as $colaborador)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $colaborador->nome_completo ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $colaborador->matricula ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $colaborador->lotacao->nomeLotacao ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $colaborador->vinculo->nomeVinculo ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ ($colaborador->status ?? false) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ($colaborador->status ?? false) ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                    Nenhum colaborador encontrado com os filtros aplicados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Rodapé do Relatório -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex justify-between items-center text-sm text-gray-500">
                    <div>
                        <strong>Sistema de RH</strong> - Relatório gerado automaticamente
                    </div>
                    <div>
                        Página 1 de 1 - {{ $data_geracao ?? now()->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection