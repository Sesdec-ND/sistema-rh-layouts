@extends($layout)

@section('title', 'Meus Contracheques')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Meus Contracheques</h1>
            <p class="text-gray-600 mt-2">Acesse seus holerites e demonstrativos de pagamento</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('perfil-pessoal.show') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar ao Perfil
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-receipt mr-2 text-green-600"></i>
                Demonstrativos de Pagamento
            </h2>
            
            <div class="flex space-x-4">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option>2024</option>
                    <option>2023</option>
                    <option>2022</option>
                </select>
                
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option>Todos os meses</option>
                    <option>Janeiro</option>
                    <option>Fevereiro</option>
                    <option>Março</option>
                    <!-- ... outros meses -->
                </select>
            </div>
        </div>
    </div>

    <!-- Lista de Contracheques -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm font-semibold text-gray-700">
                <span>Mês/Ano</span>
                <span>Data de Emissão</span>
                <span>Valor Líquido</span>
                <span>Ações</span>
            </div>
        </div>
        
        <div class="divide-y divide-gray-200">
            @foreach($contracheques as $contracheque)
            <div class="px-6 py-4 hover:bg-gray-50 transition duration-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                    <div>
                        <span class="font-semibold text-gray-800">{{ $contracheque['mes'] }}</span>
                    </div>
                    
                    <div>
                        <span class="text-gray-600">{{ $contracheque['data_emissao'] }}</span>
                    </div>
                    
                    <div>
                        <span class="font-bold text-green-600 text-lg">{{ $contracheque['valor_liquido'] }}</span>
                    </div>
                    
                    <div class="flex space-x-2">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition duration-200 flex items-center">
                            <i class="fas fa-eye mr-2"></i>
                            Visualizar
                        </button>
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition duration-200 flex items-center">
                            <i class="fas fa-download mr-2"></i>
                            PDF
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-full mr-4">
                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-600">Total Recebido (2024)</h3>
                    <p class="text-2xl font-bold text-gray-800">R$ 62.400,00</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-600">Contracheques (2024)</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ count($contracheques) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-full mr-4">
                    <i class="fas fa-calendar-check text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-600">Próximo Pagamento</h3>
                    <p class="text-2xl font-bold text-gray-800">05/01/2025</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Aviso -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="bg-yellow-100 p-2 rounded-full mr-4">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-yellow-800 text-lg mb-2">Importante</h3>
                <p class="text-yellow-700">
                    Os contracheques ficam disponíveis por 36 meses. Para acessar demonstrativos 
                    mais antigos, entre em contato com o departamento financeiro.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection