@extends('layouts.app')

@section('title', 'Editar Colaborador')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <!-- Cabeçalho -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Editar Colaborador</h1>
            <p class="text-gray-600">Atualize as informações do colaborador</p>
        </div>

        <form action="{{ route('servidores.update', $servidor->id) }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informações Pessoais -->
                <div class="col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informações Pessoais</h3>
                </div>
                
                <div>
                    <label for="nome" class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo *</label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome', $servidor->nome) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nome') border-red-500 @enderror">
                    @error('nome') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $servidor->email) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                    @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="cpf" class="block text-sm font-semibold text-gray-700 mb-2">CPF *</label>
                    <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $servidor->cpf) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cpf') border-red-500 @enderror">
                    @error('cpf') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-2">Telefone</label>
                    <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $servidor->telefone) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('telefone') border-red-500 @enderror">
                    @error('telefone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Informações Profissionais -->
                <div class="col-span-2 mt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informações Profissionais</h3>
                </div>

                <div>
                    <label for="matricula" class="block text-sm font-semibold text-gray-700 mb-2">Matrícula *</label>
                    <input type="text" id="matricula" name="matricula" value="{{ old('matricula', $servidor->matricula) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('matricula') border-red-500 @enderror">
                    @error('matricula') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="cargo" class="block text-sm font-semibold text-gray-700 mb-2">Cargo *</label>
                    <input type="text" id="cargo" name="cargo" value="{{ old('cargo', $servidor->cargo) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cargo') border-red-500 @enderror">
                    @error('cargo') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="idLotacao" class="block text-sm font-semibold text-gray-700 mb-2">Lotação</label>
                    <select id="idLotacao" name="idLotacao" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('idLotacao') border-red-500 @enderror">
                        <option value="" disabled>Selecione...</option>
                        <option value="PM" {{ old('idLotacao', $servidor->idLotacao) == 'PM' ? 'selected' : '' }}>PM</option>
                        <option value="PC" {{ old('idLotacao', $servidor->idLotacao) == 'PC' ? 'selected' : '' }}>PC</option>
                        <option value="Politec" {{ old('idLotacao', $servidor->idLotacao) == 'Politec' ? 'selected' : '' }}>Politec</option>
                        <option value="Bombeiros" {{ old('idLotacao', $servidor->idLotacao) == 'Bombeiros' ? 'selected' : '' }}>Bombeiros</option>
                    </select>
                    @error('idLotacao') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="idVinculo" class="block text-sm font-semibold text-gray-700 mb-2">Vínculo</label>
                    <select id="idVinculo" name="idVinculo" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('idVinculo') border-red-500 @enderror">
                        <option value="" disabled>Selecione...</option>
                        <option value="Efetivo" {{ old('idVinculo', $servidor->idVinculo) == 'Efetivo' ? 'selected' : '' }}>Efetivo</option>
                        <option value="Comissionado" {{ old('idVinculo', $servidor->idVinculo) == 'Comissionado' ? 'selected' : '' }}>Comissionado</option>
                        <option value="Voluntário" {{ old('idVinculo', $servidor->idVinculo) == 'Voluntário' ? 'selected' : '' }}>Voluntário</option>
                    </select>
                    @error('idVinculo') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Informações de Saúde -->
                <div class="col-span-2 mt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informações de Saúde</h3>
                </div>

                <div>
                    <label for="tipoSanguineo" class="block text-sm font-semibold text-gray-700 mb-2">Tipo Sanguíneo</label>
                    <select id="tipoSanguineo" name="tipoSanguineo" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tipoSanguineo') border-red-500 @enderror">
                        <option value="" disabled>Selecione...</option>
                        <option value="A+" {{ old('tipoSanguineo', $servidor->tipoSanguineo) == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('tipoSanguineo', $servidor->tipoSanguineo) == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('tipoSanguineo', $servidor->tipoSanguineo) == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('tipoSanguineo', $servidor->tipoSanguineo) == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ old('tipoSanguineo', $servidor->tipoSanguineo) == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('tipoSanguineo', $servidor->tipoSanguineo) == 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ old('tipoSanguineo', $servidor->tipoSanguineo) == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('tipoSanguineo', $servidor->tipoSanguineo) == 'O-' ? 'selected' : '' }}>O-</option>
                    </select>
                    @error('tipoSanguineo') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="racaCor" class="block text-sm font-semibold text-gray-700 mb-2">Raça/Cor</label>
                    <select id="racaCor" name="racaCor" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('racaCor') border-red-500 @enderror">
                        <option value="" disabled>Selecione...</option>
                        <option value="Branca" {{ old('racaCor', $servidor->racaCor) == 'Branca' ? 'selected' : '' }}>Branca</option>
                        <option value="Preta" {{ old('racaCor', $servidor->racaCor) == 'Preta' ? 'selected' : '' }}>Preta</option>
                        <option value="Parda" {{ old('racaCor', $servidor->racaCor) == 'Parda' ? 'selected' : '' }}>Parda</option>
                        <option value="Amarela" {{ old('racaCor', $servidor->racaCor) == 'Amarela' ? 'selected' : '' }}>Amarela</option>
                    </select>
                    @error('racaCor') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div class="col-span-2">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select id="status" name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Ativo" {{ old('status', $servidor->status) == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="Inativo" {{ old('status', $servidor->status) == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
            </div>

            <!-- Botões -->
            <div class="flex justify-end space-x-4 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('servidores.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    Atualizar Colaborador
                </button>
            </div>
        </form>
    </div>
</div>
@endsection