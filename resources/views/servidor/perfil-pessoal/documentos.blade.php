@extends($layout)

@section('title', 'Meus Documentos')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Meus Documentos</h1>
            <p class="text-gray-600 mt-2">Acesse todos os seus documentos e contratos</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('perfil-pessoal.show') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar ao Perfil
            </a>
        </div>
    </div>

    <!-- Lista de Documentos -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-file-pdf mr-2 text-red-600"></i>
                Documentos Disponíveis
            </h2>
        </div>
        
        <div class="divide-y divide-gray-200">
            @foreach($documentos as $documento)
            <div class="px-6 py-4 hover:bg-gray-50 transition duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-red-100 p-3 rounded-lg">
                            <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $documento['nome'] }}</h3>
                            <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                                <span class="flex items-center">
                                    <i class="fas fa-file mr-1"></i>
                                    {{ $documento['tipo'] }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $documento['data_upload'] }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-weight-hanging mr-1"></i>
                                    {{ $documento['tamanho'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition duration-200 flex items-center">
                            <i class="fas fa-eye mr-2"></i>
                            Visualizar
                        </button>
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition duration-200 flex items-center">
                            <i class="fas fa-download mr-2"></i>
                            Download
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Informações -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="bg-blue-100 p-2 rounded-full mr-4">
                <i class="fas fa-info-circle text-blue-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-blue-800 text-lg mb-2">Informações Importantes</h3>
                <ul class="text-blue-700 list-disc list-inside space-y-1">
                    <li>Os documentos ficam disponíveis por 24 meses</li>
                    <li>Para solicitar documentos antigos, entre em contato com o RH</li>
                    <li>Mantenha seus documentos em local seguro</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection