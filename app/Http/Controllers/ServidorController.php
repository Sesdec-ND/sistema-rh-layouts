<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ServidorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servidores = Servidor::all();
        return view('admin.colaborador', compact('servidores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $perfis = \App\Models\Perfil::all();
         return view('servidor.colaboradores.create', compact('perfis'));
        // Se você quiser uma página separada para criar
        // return view('servidor.colaboradores.create');
        
        // Ou se está usando modal, redirecione para index
        // return redirect()->route('servidores.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Dados recebidos no request:', $request->all());
        \Log::info('Arquivos recebidos:', $request->allFiles());

        $validated = $request->validate([
            'matricula' => 'required|string|max:20|unique:servidores,matricula',
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:servidores,email',
            'cpf' => 'required|string|max:14|unique:servidores,cpf',
            'rg' => 'required|string|max:20',
            'data_nascimento' => 'required|date',
            'genero' => 'required|in:Masculino,Feminino',
            'estado_civil' => 'nullable|string|max:50',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'tipo_sanguineo' => 'nullable|string|max:5',
            'pispasep' => 'nullable|string|max:20',
            'data_nomeacao' => 'nullable|date',
            'status' => 'required|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();
        
        try {
            // Processar foto
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                \Log::info('Processando foto:', [
                    'nome' => $foto->getClientOriginalName(),
                    'tamanho' => $foto->getSize(),
                    'mime' => $foto->getMimeType()
                ]);

                // Nome único para a foto
                $fotoNome = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                
                // Salvar no storage
                $fotoPath = $foto->storeAs('servidores/fotos', $fotoNome, 'public');
                $validated['foto'] = $fotoPath;
                
                \Log::info('Foto salva com sucesso: ' . $fotoPath);
            }

            // Criar servidor
            $servidor = Servidor::create($validated);
            
            DB::commit();

            \Log::info('Servidor criado com sucesso. ID: ' . $servidor->id);

            return redirect()->route('servidores.index')
                ->with('success', 'Servidor cadastrado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('ERRO no cadastro:', [
                'mensagem' => $e->getMessage(),
                'arquivo' => $e->getFile(),
                'linha' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Erro ao cadastrar servidor: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $servidor = Servidor::with([
        'ocorrencias',
        'lotacao', 
        'vinculo',
        'dependentes',
        'historicosPagamento',
        'ferias',
        'formacoes',
        'cursos'
    ])->findOrFail($id);

    return view('servidor.colaboradores.show', compact('servidor'));

        try {
            $servidor = Servidor::findOrFail($id);
            return view('servidor.colaboradores.show', compact('servidor'));
        } catch (\Exception $e) {
            return redirect()->route('servidores.index')
                ->with('error', 'Servidor não encontrado.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $servidor = Servidor::findOrFail($id);
            
            // Se você tiver lotações e vínculos
            $lotacoes = \App\Models\Lotacao::all() ?? [];
            $vinculos = \App\Models\Vinculo::all() ?? [];
            
            return view('servidor.colaboradores.edit', compact('servidor', 'lotacoes', 'vinculos'));
        } catch (\Exception $e) {
            return redirect()->route('servidores.index')
                ->with('error', 'Servidor não encontrado.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $servidor = Servidor::findOrFail($id);

            $validated = $request->validate([
                'matricula' => 'required|string|max:20|unique:servidores,matricula,' . $id,
                'nome_completo' => 'required|string|max:255',
                'email' => 'required|email|unique:servidores,email,' . $id,
                'cpf' => 'required|string|max:14|unique:servidores,cpf,' . $id,
                'rg' => 'required|string|max:20',
                'data_nascimento' => 'required|date',
                'genero' => 'required|in:Masculino,Feminino',
                'estado_civil' => 'nullable|string|max:50',
                'telefone' => 'nullable|string|max:20',
                'endereco' => 'nullable|string|max:255',
                'tipo_sanguineo' => 'nullable|string|max:5',
                'pispasep' => 'nullable|string|max:20',
                'data_nomeacao' => 'nullable|date',
                'status' => 'required|boolean',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            DB::beginTransaction();

            // Upload da nova foto se existir
            if ($request->hasFile('foto')) {
                // Deletar foto antiga se existir
                if ($servidor->foto && Storage::disk('public')->exists($servidor->foto)) {
                    Storage::disk('public')->delete($servidor->foto);
                }
                
                $fotoPath = $request->file('foto')->store('servidores/fotos', 'public');
                $validated['foto'] = $fotoPath;
            }

            $servidor->update($validated);

            DB::commit();

            return redirect()->route('servidores.index')
                ->with('success', 'Servidor atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Erro ao atualizar servidor: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        try {
            $servidor = Servidor::findOrFail($id);
            
            // Use soft delete (se estiver usando SoftDeletes)
            $servidor->delete();

            return redirect()->route('servidores.index')
                ->with('success', 'Servidor movido para a lixeira com sucesso!');

        } catch (\Exception $e) {
            return redirect()->route('servidores.index')
                ->with('error', 'Erro ao excluir servidor: ' . $e->getMessage());
        }
    }
    public function lixeira()
    {
        $servidores = Servidor::onlyTrashed()->with('perfil')->paginate(10);
        
        return view('servidor.colaboradores.delete', compact('servidores'));
    }

    /**
     * Restore a deleted server.
     */
    public function restore($id)
    {
        try {
            $servidor = Servidor::onlyTrashed()->findOrFail($id);
            $servidor->restore();

            return redirect()->route('servidores.lixeira')
                ->with('success', 'Servidor restaurado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->route('servidores.lixeira')
                ->with('error', 'Erro ao restaurar servidor: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete a server.
     */
    public function forceDelete($id)
    {
        try {
            $servidor = Servidor::onlyTrashed()->findOrFail($id);
            
            // Remove a foto se existir
            if ($servidor->foto) {
                Storage::disk('public')->delete($servidor->foto);
            }
            
            $servidor->forceDelete();

            return redirect()->route('servidores.lixeira')
                ->with('success', 'Servidor excluído permanentemente com sucesso!');

        } catch (\Exception $e) {
            return redirect()->route('servidores.lixeira')
                ->with('error', 'Erro ao excluir servidor: ' . $e->getMessage());
        }
    }

    /**
     * Empty the trash.
     */
    public function emptyTrash()
    {
        try {
            $servidores = Servidor::onlyTrashed()->get();
            
            foreach ($servidores as $servidor) {
                if ($servidor->foto) {
                    Storage::disk('public')->delete($servidor->foto);
                }
                $servidor->forceDelete();
            }

            return redirect()->route('servidores.lixeira')
                ->with('success', 'Lixeira esvaziada com sucesso!');

        } catch (\Exception $e) {
            return redirect()->route('servidores.lixeira')
                ->with('error', 'Erro ao esvaziar lixeira: ' . $e->getMessage());
        }
    }
}