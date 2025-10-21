<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 🔴 **ALTERAÇÃO:** Validação com CPF em vez de username
        $credentials = $request->validate([
            'cpf' => 'required|string',
            'password' => 'required'
        ]);

        // **ALTERAÇÃO:** Buscar usuário pelo CPF
        // $user = User::where('cpf', $request->cpf)->first();

        // 🔴 **BUSCA FLEXIVEL:** Aceita CPF com ou sem formatação
        $cpfBusca = preg_replace('/[^0-9]/', '', $request->cpf);
        $user = User::whereRaw("REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), ' ', '') = ?", [$cpfBusca])->first();

        // 🔴 **ALTERAÇÃO:** Verificar se usuário existe e senha está correta
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            
            // Redirecionar baseado no perfil
            return match($user->perfil->nomePerfil) {
                'RH' => redirect()->route('admin.dashboard'),
                'Diretor Executivo' => redirect()->route('diretor.dashboard'),
                'Colaborador' => redirect()->route('colaborador.dashboard'),
                default => redirect()->route('dashboard')
            };
        }

        // 🔴 **ALTERAÇÃO:** Mensagem de erro atualizada
        return back()->withErrors([
            'cpf' => 'CPF ou senha inválidos.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}