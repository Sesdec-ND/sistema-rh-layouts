@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Login - Sistema RH</h2>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        {{-- 🔴 **ALTERAÇÃO:** Campo CPF em vez de username --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="cpf">
                CPF
            </label>
            <input type="text" 
                   name="cpf" 
                   id="cpf" 
                   placeholder="000.000.000-00"
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   value="{{ old('cpf') }}"
                   required 
                   autofocus>
            @error('cpf')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Senha
            </label>
            <input type="password" 
                   name="password" 
                   id="password" 
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   placeholder="Digite sua senha"
                   required>
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" 
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:shadow-outline">
            Entrar
        </button>
    </form>

    {{-- 🔴 **ALTERAÇÃO:** Informação adicional sobre o login --}}
    <div class="mt-4 text-center text-sm text-gray-600">
        <p>Use seu CPF e senha para acessar o sistema</p>
    </div>
</div>

{{-- 🔴 **ALTERAÇÃO:** Script para formatação do CPF --}}
<script>
document.getElementById('cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }
    
    e.target.value = value;
});
</script>
@endsection