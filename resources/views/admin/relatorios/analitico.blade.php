@extends('layouts.admin')

@section('title', 'Dashboard Analítico')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Analítico</h1>
            <p class="text-gray-600 mt-2">Métricas e visualizações em tempo real</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                <i class="fas fa-print mr-2"></i>Imprimir
            </button>
        </div>
    </div>

    <!-- Filtros Rápidos -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filtros</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ano</label>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lotação</label>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todas</option>
                    @foreach($lotacoes ?? [] as $lotacao)
                    <option value="{{ $lotacao->idLotacao ?? $lotacao->id }}">{{ $lotacao->nomeLotacao ?? 'N/A' }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Vínculo</label>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    @foreach($vinculos ?? [] as $vinculo)
                    <option value="{{ $vinculo->idVinculo ?? $vinculo->id }}">{{ $vinculo->nomeVinculo ?? 'N/A' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition duration-200">
                    Aplicar Filtros
                </button>
            </div>
        </div>
    </div>

    <!-- Grid de Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Distribuição por Gênero -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribuição por Gênero</h3>
            <div class="h-64">
                <canvas id="generoChart"></canvas>
            </div>
        </div>

        <!-- Distribuição por Lotação -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribuição por Lotação</h3>
            <div class="h-64">
                <canvas id="lotacaoChart"></canvas>
            </div>
        </div>

        <!-- Distribuição por Vínculo -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribuição por Vínculo</h3>
            <div class="h-64">
                <canvas id="vinculoChart"></canvas>
            </div>
        </div>

        <!-- Faixa Etária -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribuição por Faixa Etária</h3>
            <div class="h-64">
                <canvas id="idadeChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabela de Estatísticas -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Resumo Estatístico</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="p-4 border border-gray-200 rounded-lg">
                <p class="text-2xl font-bold text-blue-600">{{ $estatisticas['total_colaboradores'] ?? 0 }}</p>
                <p class="text-sm text-gray-600">Total Colaboradores</p>
            </div>
            <div class="p-4 border border-gray-200 rounded-lg">
                <p class="text-2xl font-bold text-green-600">{{ $estatisticas['colaboradores_ativos'] ?? 0 }}</p>
                <p class="text-sm text-gray-600">Ativos</p>
            </div>
            <div class="p-4 border border-gray-200 rounded-lg">
                <p class="text-2xl font-bold text-purple-600">{{ $estatisticas['total_lotacoes'] ?? 0 }}</p>
                <p class="text-sm text-gray-600">Lotações</p>
            </div>
            <div class="p-4 border border-gray-200 rounded-lg">
                <p class="text-2xl font-bold text-orange-600">{{ $estatisticas['total_vinculos'] ?? 0 }}</p>
                <p class="text-sm text-gray-600">Vínculos</p>
            </div>
        </div>
    </div>

    <!-- Dados dos Gráficos (para debug) -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Dados dos Gráficos</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <h4 class="font-semibold mb-2">Distribuição por Gênero:</h4>
                <pre class="bg-gray-100 p-2 rounded text-xs">{{ json_encode($dados_graficos['distribuicao_genero'] ?? [], JSON_PRETTY_PRINT) }}</pre>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Distribuição por Lotação:</h4>
                <pre class="bg-gray-100 p-2 rounded text-xs">{{ json_encode($dados_graficos['distribuicao_lotacao'] ?? [], JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Dados dos gráficos do controller - CORRIGIDO
const generoData = {!! json_encode($dados_graficos['distribuicao_genero'] ?? [], JSON_HEX_TAG) !!};
const lotacaoData = {!! json_encode($dados_graficos['distribuicao_lotacao'] ?? [], JSON_HEX_TAG) !!};
const vinculoData = {!! json_encode($dados_graficos['distribuicao_vinculo'] ?? [], JSON_HEX_TAG) !!};
const idadeData = {!! json_encode($dados_graficos['faixa_etaria'] ?? [], JSON_HEX_TAG) !!};

console.log('Dados dos gráficos:', {
    genero: generoData,
    lotacao: lotacaoData, // CORRIGIDO: era 'lotacaOata'
    vinculo: vinculoData,
    idade: idadeData
});

// Gráfico de Gênero
if (generoData && Object.keys(generoData).length > 0) {
    new Chart(document.getElementById('generoChart'), {
        type: 'pie',
        data: {
            labels: Object.keys(generoData),
            datasets: [{
                data: Object.values(generoData),
                backgroundColor: ['#3B82F6', '#EC4899', '#8B5CF6', '#10B981']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
} else {
    document.getElementById('generoChart').innerHTML = '<p class="text-gray-500 text-center py-8">Nenhum dado disponível</p>';
}

// Gráfico de Lotação
if (lotacaoData && lotacaoData.length > 0) {
    new Chart(document.getElementById('lotacaoChart'), {
        type: 'bar',
        data: {
            labels: lotacaoData.map(item => item.lotacao),
            datasets: [{
                label: 'Colaboradores',
                data: lotacaoData.map(item => item.total),
                backgroundColor: '#10B981'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
} else {
    document.getElementById('lotacaoChart').innerHTML = '<p class="text-gray-500 text-center py-8">Nenhum dado disponível</p>';
}

// Gráfico de Vínculo
if (vinculoData && vinculoData.length > 0) {
    new Chart(document.getElementById('vinculoChart'), {
        type: 'doughnut',
        data: {
            labels: vinculoData.map(item => item.vinculo),
            datasets: [{
                data: vinculoData.map(item => item.total),
                backgroundColor: ['#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
} else {
    document.getElementById('vinculoChart').innerHTML = '<p class="text-gray-500 text-center py-8">Nenhum dado disponível</p>';
}

// Gráfico de Faixa Etária
if (idadeData && Object.keys(idadeData).length > 0) {
    new Chart(document.getElementById('idadeChart'), {
        type: 'line',
        data: {
            labels: Object.keys(idadeData),
            datasets: [{
                label: 'Colaboradores',
                data: Object.values(idadeData),
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                fill: true,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
} else {
    document.getElementById('idadeChart').innerHTML = '<p class="text-gray-500 text-center py-8">Nenhum dado disponível</p>';
}
</script>
@endpush