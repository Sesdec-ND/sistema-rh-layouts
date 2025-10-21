@extends('layouts.admin')

@section('title', 'Relatório de Performance - RH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Relatório de Performance - {{ $trimestre_ano }}</h1>
            <p class="text-gray-600 mt-2">Métricas de desempenho e produtividade</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.relatorios.performance') }}?download=1" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                <i class="fas fa-download mr-2"></i>
                Baixar PDF
            </a>
            <a href="{{ route('admin.relatorios') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar
            </a>
        </div>
    </div>

    <!-- Métricas Gerais -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 font-semibold">Média Geral</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $media_geral_empresa }}/10</div>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 font-semibold">Colaboradores Avaliados</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $total_avaliados }}</div>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 font-semibold">Período</div>
                    <div class="text-lg font-semibold text-gray-800">{{ $trimestre_ano }}</div>
                </div>
                <div class="bg-purple-100 p-3 rounded-lg">
                    <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 font-semibold">Data do Relatório</div>
                    <div class="text-lg font-semibold text-gray-800">{{ $data_geracao }}</div>
                </div>
                <div class="bg-orange-100 p-3 rounded-lg">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Performance -->
    <div class="bg-white rounded-xl shadow-md">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Desempenho Individual</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nome</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Matrícula</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Lotação</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Avaliação</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Produtividade</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pontualidade</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Média Geral</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($performance as $desempenho)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $desempenho['nome'] }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $desempenho['matricula'] }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $desempenho['lotacao'] }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <div class="flex items-center">
                                <span class="mr-2">{{ $desempenho['avaliacao_desempenho'] }}/10</span>
                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $desempenho['avaliacao_desempenho'] * 10 }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <div class="flex items-center">
                                <span class="mr-2">{{ $desempenho['produtividade'] }}%</span>
                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $desempenho['produtividade'] }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <div class="flex items-center">
                                <span class="mr-2">{{ $desempenho['pontualidade'] }}%</span>
                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $desempenho['pontualidade'] }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                            <span class="px-2 py-1 rounded-full {{ $desempenho['media_geral'] >= 8 ? 'bg-green-100 text-green-800' : ($desempenho['media_geral'] >= 6 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $desempenho['media_geral'] }}/10
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection