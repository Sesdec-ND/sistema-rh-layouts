<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerfisAcessoController extends Controller
{
    public function index()
    {
        // Listar todos os perfis da tabela existente
        $perfis = DB::table('perfis')->get();
        
        return view('admin.perfis-acesso', compact('perfis'));
    }

    public function edit($id)
    {
        $perfil = DB::table('perfis')->where('id', $id)->first();
        
        if (!$perfil) {
            return redirect()->route('admin.perfis-acesso')
                ->with('error', 'Perfil não encontrado!');
        }

        return view('admin.perfil-edit', compact('perfil'));
    }

    public function update(Request $request, $id)
    {
        $perfil = DB::table('perfis')->where('id', $id)->first();
        
        if (!$perfil) {
            return redirect()->route('admin.perfis-acesso')
                ->with('error', 'Perfil não encontrado!');
        }

        // Decodificar as permissões atuais
        $permissoes = json_decode($perfil->permissoes, true);
        
        // Atualizar apenas as permissões específicas que foram enviadas
        if ($request->has('permissoes')) {
            $permissoes = array_merge($permissoes, $request->permissoes);
        }

        DB::table('perfis')
            ->where('id', $id)
            ->update([
                'nomePerfil' => $request->nomePerfil ?? $perfil->nomePerfil,
                'descricao' => $request->descricao ?? $perfil->descricao,
                'permissoes' => json_encode($permissoes),
                'updated_at' => now()
            ]);

        return redirect()->route('admin.perfis-acesso')
            ->with('success', 'Perfil atualizado com sucesso!');
    }

    public function managePermissions($id)
    {
        $perfil = DB::table('perfis')->where('id', $id)->first();
        
        if (!$perfil) {
            return redirect()->route('admin.perfis-acesso')
                ->with('error', 'Perfil não encontrado!');
        }

        $permissoes = json_decode($perfil->permissoes, true);
        
        return view('admin.permissoes', compact('perfil', 'permissoes'));
    }

    public function updatePermissions(Request $request, $id)
    {
        $perfil = DB::table('perfis')->where('id', $id)->first();
        
        if (!$perfil) {
            return redirect()->route('admin.perfis-acesso')
                ->with('error', 'Perfil não encontrado!');
        }

        DB::table('perfis')
            ->where('id', $id)
            ->update([
                'permissoes' => json_encode($request->permissoes),
                'updated_at' => now()
            ]);

        return redirect()->route('admin.perfis-acesso')
            ->with('success', 'Permissões atualizadas com sucesso!');
    }
}