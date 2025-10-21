<?php
// [file name]: UsuarioController.php

namespace App\Http\Controllers\Admin;

use App\Models\Servidor;
use App\Models\User;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller
{
    /**
     * Lista todos os colaboradores para gerenciar acesso
     */
    public function indexAcessoSistema()
    {
        // Use paginate() em vez de get() para ter paginação
        $servidores = Servidor::with(['user', 'user.perfil'])->paginate(10); // 10 itens por página
        $perfis = Perfil::all();
        
        return view('admin.acesso-sistema.acesso-sistema', compact('servidores', 'perfis'));
    }

    /**
     * Mostra formulário para criar usuário a partir de servidor
     */
    public function createUserFromServidor(Servidor $servidor)
    {
        $perfis = Perfil::all();
        
        // Verificar se já existe usuário para este servidor
        // $usuarioExistente = User::where('cpf', $servidor->cpf)->first();

        // 🔴 POR esta (busca flexível):
        $cpfBusca = preg_replace('/[^0-9]/', '', $servidor->cpf);
        $usuarioExistente = User::whereRaw("REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), ' ', '') = ?", [$cpfBusca])->first();
        
        return view('admin.acesso-sistema.atribuir-perfil', compact('servidor', 'perfis', 'usuarioExistente'));
    }
    
    /**
     * Cria usuário com perfil a partir de servidor
     */
    public function storeUserFromServidor(Request $request, Servidor $servidor)
    {
        $request->validate([
            'perfil_id' => 'required|exists:perfis,id',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8|confirmed',
        ]);
        
        // Verificar se já existe usuário com este CPF
        // $usuarioExistente = User::where('cpf', $servidor->cpf)->first();

        // 🔴 POR esta (busca flexível):
        $cpfBusca = preg_replace('/[^0-9]/', '', $servidor->cpf);
        $usuarioExistente = User::whereRaw("REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), ' ', '') = ?", [$cpfBusca])->first();
        
        if ($usuarioExistente) {
            return redirect()->back()
                ->with('error', 'Já existe um usuário cadastrado com este CPF!')
                ->withInput();
        }
        
        // Criar usuário - O CPF será usado como login
        $user = User::create([
            'name' => $servidor->nome_completo,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'cpf' => $servidor->cpf,
            'rg' => $servidor->rg,
            'perfil_id' => $request->perfil_id,
            'status' => 'ativo',
        ]);
        
        return redirect()->route('admin.acesso-sistema')
        ->with('success', 'Acesso criado com sucesso! O colaborador pode fazer login usando o CPF: ' . $servidor->cpf);
    }
    
    /**
     * Atualizar perfil de usuário existente
     */
    public function updateUserPerfil(Request $request, User $user)
    {
        $request->validate([
            'perfil_id' => 'required|exists:perfis,id',
        ]);
        
        $user->update([
            'perfil_id' => $request->perfil_id,
        ]);
        
        return redirect()->route('admin.acesso-sistema')
            ->with('success', 'Perfil de acesso atualizado com sucesso!');
    }

    /**
     * Revogar acesso do usuário ao sistema
     */
    public function revogarAcesso(User $user)
    {
        $user->delete();
        
        return redirect()->route('admin.acesso-sistema')
            ->with('success', 'Acesso ao sistema revogado com sucesso!');
    }
}