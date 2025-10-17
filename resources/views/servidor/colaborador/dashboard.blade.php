{{-- resources/views/dashboard.blade.php ou onde estiver seu card --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <!-- Card Total Colaboradores - Agora clicável -->
    <a href="{{ route('servidores.index') }}" class="block transform transition-transform hover:scale-105">
        <div class="bg-white rounded-xl shadow-md p-6 cursor-pointer hover:shadow-lg transition-shadow duration-200 border-2 border-transparent hover:border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Colaboradores</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalServidores }}</p>
                </div>
            </div>
            <div class="mt-2 text-xs text-blue-600 font-medium flex items-center">
                <span>Clique para gerenciar</span>
                <i class="fas fa-arrow-right ml-1"></i>
            </div>
        </div>
    </a>

    <!-- Outros cards (se houver) -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <i class="fas fa-user-check text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Ativos Hoje</p>
                <p class="text-2xl font-bold text-gray-800">3</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                <i class="fas fa-user-clock text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Em Folga</p>
                <p class="text-2xl font-bold text-gray-800">1</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                <i class="fas fa-building text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Novos/Mês</p>
                <p class="text-2xl font-bold text-gray-800">2</p>
            </div>
        </div>
    </div>
</div>
