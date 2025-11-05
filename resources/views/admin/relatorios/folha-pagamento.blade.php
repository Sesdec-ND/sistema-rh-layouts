@extends('layouts.admin')

@section('title', 'Relatório Folha de Pagamento - RH')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Folha de Pagamento - {{ $mes_ano }}</h1>
            <p class="text-gray-600 mt-2">Relatório completo da folha de pagamento</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.relatorios.folha-pagamento') }}?download=1" 
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
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

    <!-- Resumo Financeiro -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 font-semibold">Total da Folha</div>
                    <div class="text-2xl font-bold text-gray-800">R$ {{ number_format($total_folha, 2, ',', '.') }}</div>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 font-semibold">Funcionários</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $total_funcionarios }}</div>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 font-semibold">Data do Relatório</div>
                    <div class="text-lg font-semibold text-gray-800">{{ $data_geracao }}</div>
                </div>
                <div class="bg-purple-100 p-3 rounded-lg">
                    <i class="fas fa-calendar text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Folha de Pagamento -->
    <div class="bg-white rounded-xl shadow-md">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Detalhamento da Folha</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nome</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Matrícula</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Lotação</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Salário Base</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Benefícios</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Descontos</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Salário Líquido</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($folha_pagamento as $funcionario)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $funcionario['nome'] }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $funcionario['matricula'] }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $funcionario['lotacao'] }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">R$ {{ number_format($funcionario['salario_base'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-green-600">R$ {{ number_format($funcionario['beneficios'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-red-600">R$ {{ number_format($funcionario['descontos'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">R$ {{ number_format($funcionario['salario_liquido'], 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">Totais:</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">R$ {{ number_format(collect($folha_pagamento)->sum('salario_base'), 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-green-600">R$ {{ number_format(collect($folha_pagamento)->sum('beneficios'), 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-red-600">R$ {{ number_format(collect($folha_pagamento)->sum('descontos'), 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">R$ {{ number_format($total_folha, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection