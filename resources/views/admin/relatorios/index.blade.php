@extends('layouts.admin')

@section('title', 'Relatórios - Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Relatórios & Analytics</h1>
            <p class="text-gray-600 mt-2">Dashboard completo de relatórios e métricas do RH</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.relatorios.analitico') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                <i class="fas fa-chart-bar mr-2"></i>Dashboard Analítico
            </a>
        </div>
    </div>

    <!-- Cards de Estatísticas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Colaboradores</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $dashboardData['total_colaboradores'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-2 text-sm text-green-600">
                <i class="fas fa-arrow-up mr-1"></i>
                {{ $dashboardData['colaboradores_ativos'] }} ativos
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Lotações</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $dashboardData['total_lotacoes'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-building text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Vínculos</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $dashboardData['total_vinculos'] }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-link text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Distribuição</p>
                    <p class="text-3xl font-bold text-gray-800">{{ count($dashboardData['distribuicao_genero']) }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <i class="fas fa-chart-pie text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-2 text-sm text-gray-600">
                Por gênero e lotação
            </div>
        </div>
    </div>

    <!-- Gráfico de Distribuição por Gênero (Mini) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribuição por Gênero</h3>
            <div class="h-48 flex items-center justify-center">
                <canvas id="generoChartMini"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Últimas Contratações</h3>
            <div class="space-y-3">
                @foreach($dashboardData['ultimas_contratacoes'] as $contratacao)
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-2 rounded-full">
                            <i class="fas fa-user text-blue-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-gray-800">{{ $contratacao->nome_completo }}</p>
                            <p class="text-sm text-gray-600">{{ $contratacao->lotacao->nome_lotacao ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <span class="text-sm text-gray-500">{{ $contratacao->created_at->format('d/m/Y') }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Cards de Relatórios Disponíveis -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Relatórios Disponíveis</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Relatório de Colaboradores -->
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Disponível</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Colaboradores</h3>
                <p class="text-gray-600 text-sm mb-4">Relatório completo com filtros avançados</p>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.relatorios.colaboradores') }}" 
                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-semibold transition duration-200 text-center">
                        <i class="fas fa-eye mr-1"></i>Abrir
                    </a>
                </div>
            </div>

            <!-- Relatório Analítico -->
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Novo</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Dashboard Analítico</h3>
                <p class="text-gray-600 text-sm mb-4">Gráficos e métricas em tempo real</p>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.relatorios.analitico') }}" 
                       class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg text-sm font-semibold transition duration-200 text-center">
                        <i class="fas fa-chart-line mr-1"></i>Visualizar
                    </a>
                </div>
            </div>

            <!-- Folha de Pagamento -->
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="fas fa-file-invoice-dollar text-green-600 text-xl"></i>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Disponível</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Folha de Pagamento</h3>
                <p class="text-gray-600 text-sm mb-4">Relatório mensal completo</p>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.relatorios.folha-pagamento') }}" 
                       class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm font-semibold transition duration-200 text-center">
                        <i class="fas fa-eye mr-1"></i>Abrir
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de distribuição por gênero
    const generoData = @json($dashboardData['distribuicao_genero']);
    
    const generoChart = new Chart(document.getElementById('generoChartMini'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(generoData),
            datasets: [{
                data: Object.values(generoData),
                backgroundColor: [
                    '#3B82F6', // Azul
                    '#EC4899', // Rosa
                    '#8B5CF6', // Roxo
                    '#10B981', // Verde
                ],
                borderWidth: 2,
                borderColor: '#fff'
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
</script>
@endpush
@endsection