{{-- No index dos servidores (resources/views/servidor/index.blade.php) --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <!-- Card Total Servidores -->
    <a href="{{ route('servidores.index') }}" class="block transform transition-transform hover:scale-105">
        <div class="bg-white rounded-xl shadow-md p-6 cursor-pointer hover:shadow-lg transition-shadow duration-200 border-2 border-transparent hover:border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Servidores</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $servidores->total() }}</p>
                </div>
            </div>
        </div>
    </a>

    <!-- Card Ativos -->
    <a href="{{ route('servidores.index') }}?status=ativo" class="block transform transition-transform hover:scale-105">
        <div class="bg-white rounded-xl shadow-md p-6 cursor-pointer hover:shadow-lg transition-shadow duration-200 border-2 border-transparent hover:border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-user-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Ativos</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $servidores->total() }}</p>
                </div>
            </div>
        </div>
    </a>

    <!-- Card Efetivos -->
    <a href="{{ route('servidores.index') }}?vinculo=efetivo" class="block transform transition-transform hover:scale-105">
        <div class="bg-white rounded-xl shadow-md p-6 cursor-pointer hover:shadow-lg transition-shadow duration-200 border-2 border-transparent hover:border-orange-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                    <i class="fas fa-user-clock text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Efetivos</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ \App\Models\Servidor::where('id_vinculo', 'Efetivo')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </a>

    <!-- Card Lotação PM -->
    <a href="{{ route('servidores.index') }}?lotacao=pm" class="block transform transition-transform hover:scale-105">
        <div class="bg-white rounded-xl shadow-md p-6 cursor-pointer hover:shadow-lg transition-shadow duration-200 border-2 border-transparent hover:border-purple-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <i class="fas fa-building text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Lotação PM</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ \App\Models\Servidor::where('id_lotacao', 'PM')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </a>
</div>
