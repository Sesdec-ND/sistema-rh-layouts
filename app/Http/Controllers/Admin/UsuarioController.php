<?php

namespace App\Http\Controllers\Admin;

use App\Models\Servidor;
use App\Models\User;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller
{
    /**
     * Lista todos os colaboradores para gerenciar acesso
     */
    public function indexAcessoSistema()
    {
        // Agora que os CPFs estão padronizados, o relacionamento funciona direto
        $servidores = Servidor::with(['vinculo', 'lotacao', 'user.perfil'])
            ->paginate(10);
        
        $perfis = Perfil::all();
        
        return view('admin.acesso-sistema.acesso-sistema', [
            'servidores' => $servidores,
            'perfis' => $perfis
        ]);
    }

    /**
     * Mostra formulário para criar usuário a partir de servidor
     */
    public function createUserFromServidor(Servidor $servidor)
    {
<<<<<<< HEAD
=======
        // Buscar servidor pelo id
        $servidor = Servidor::findOrFail($servidor);
>>>>>>> 0abed94 (mostrando servidor por id e config de pdf)
        $perfis = Perfil::all();
        
        // Buscar usuário existente com CPF limpo
        $cpfLimpo = preg_replace('/[^0-9]/', '', $servidor->cpf);
        $usuarioExistente = User::whereRaw("REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), ' ', '') = ?", [$cpfLimpo])
            ->with('perfil')
            ->first();
        
        Log::info('Buscando usuário existente', [
            'servidor_cpf' => $servidor->cpf,
            'cpf_limpo' => $cpfLimpo,
            'usuario_encontrado' => $usuarioExistente ? 'Sim' : 'Não'
        ]);
        
        return view('admin.acesso-sistema.atribuir-perfil', compact('servidor', 'perfis', 'usuarioExistente'));
    }
    
    /**
     * Cria usuário com perfil a partir de servidor
     */
    public function storeUserFromServidor(Request $request, Servidor $servidor)
    {
<<<<<<< HEAD
        // Limpar CPF do servidor para comparação
        $cpfLimpo = preg_replace('/[^0-9]/', '', $servidor->cpf);
        
        // Verificar se já existe usuário com este CPF
        $usuarioExistente = User::whereRaw("REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), ' ', '') = ?", [$cpfLimpo])->first();
        
        if ($usuarioExistente) {
            Log::warning('Tentativa de criar usuário duplicado', [
                'servidor_cpf' => $servidor->cpf,
                'usuario_existente_id' => $usuarioExistente->id
            ]);
            
            return redirect()->back()
                ->with('error', 'Já existe um usuário cadastrado com este CPF!')
                ->withInput();
        }
        
        // Validação
        $request->validate([
            'perfil_id' => 'required|exists:perfis,id',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8|confirmed',
        ], [
            'perfil_id.required' => 'O perfil de acesso é obrigatório.',
            'perfil_id.exists' => 'Perfil de acesso inválido.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Digite um email válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'username.required' => 'O nome de usuário é obrigatório.',
            'username.unique' => 'Este nome de usuário já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);
        
        try {
            // Criar usuário - O CPF será formatado automaticamente pelo mutator do User
=======
        $servidorId = $servidor; // Guardar o id antes de buscar
        
        try {
            // Buscar servidor pelo id
            $servidor = Servidor::findOrFail($servidor);
            
            $validated = $request->validate([
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
                return redirect()->route('admin.acesso-sistema.atribuir', $servidor->id)
                    ->with('error', 'Já existe um usuário cadastrado com este CPF!')
                    ->withInput();
            }
            
            // Criar usuário - O CPF será usado como login
>>>>>>> 0abed94 (mostrando servidor por id e config de pdf)
            $user = User::create([
                'name' => $servidor->nome_completo,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'cpf' => $servidor->cpf, // Será formatado pelo mutator
                'rg' => $servidor->rg,
                'perfil_id' => $request->perfil_id,
                'status' => 'ativo',
            ]);
            
            Log::info('Usuário criado com sucesso', [
                'user_id' => $user->id,
                'servidor_cpf' => $servidor->cpf,
                'user_cpf' => $user->cpf
            ]);
            
            return redirect()->route('admin.acesso-sistema')
                ->with('success', 'Acesso criado com sucesso! O colaborador pode fazer login usando o CPF: ' . $servidor->cpf);
<<<<<<< HEAD
                
        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário', [
                'error' => $e->getMessage(),
                'servidor_id' => $servidor->matricula
            ]);
            
            return redirect()->back()
=======
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Em caso de erro de validação, redirecionar para a página de atribuir perfil
            return redirect()->route('admin.acesso-sistema.atribuir', $servidorId)
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            // Em caso de outros erros, também redirecionar para a página de atribuir perfil
            return redirect()->route('admin.acesso-sistema.atribuir', $servidorId)
>>>>>>> 0abed94 (mostrando servidor por id e config de pdf)
                ->with('error', 'Erro ao criar acesso: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Atualizar perfil de usuário existente
     */
    public function updateUserPerfil(Request $request, User $user)
    {
        $request->validate([
            'perfil_id' => 'required|exists:perfis,id',
        ], [
            'perfil_id.required' => 'O perfil de acesso é obrigatório.',
            'perfil_id.exists' => 'Perfil de acesso inválido.',
        ]);
        
        try {
            $perfilAntigo = $user->perfil->nomePerfil ?? 'Sem perfil';
            
            $user->update([
                'perfil_id' => $request->perfil_id,
            ]);
            
            $perfilNovo = $user->fresh()->perfil->nomePerfil;
            
            Log::info('Perfil de usuário atualizado', [
                'user_id' => $user->id,
                'perfil_antigo' => $perfilAntigo,
                'perfil_novo' => $perfilNovo
            ]);
            
            return redirect()->route('admin.acesso-sistema')
                ->with('success', "Perfil atualizado de '$perfilAntigo' para '$perfilNovo' com sucesso!");
                
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar perfil', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            
            return redirect()->back()
                ->with('error', 'Erro ao atualizar perfil: ' . $e->getMessage());
        }
    }

    /**
     * Revogar acesso do usuário ao sistema
     */
    public function revogarAcesso(User $user)
    {
        try {
            $userName = $user->name;
            $userId = $user->id;
            
            $user->delete();
            
            Log::info('Acesso revogado', [
                'user_id' => $userId,
                'user_name' => $userName
            ]);
            
            return redirect()->route('admin.acesso-sistema')
                ->with('success', "Acesso de '$userName' revogado com sucesso!");
                
        } catch (\Exception $e) {
            Log::error('Erro ao revogar acesso', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            
            return redirect()->back()
                ->with('error', 'Erro ao revogar acesso: ' . $e->getMessage());
        }
    }
}