<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servidor;
use App\Models\Lotacao;
use App\Models\Vinculo;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColaboradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->perfil->nomePerfil !== 'Colaborador') {
                abort(403, 'Acesso não autorizado');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $servidores = Servidor::with('perfil')->get();
        $lotacoes = Lotacao::where('status', true)->get();
        $vinculos = Vinculo::all();
        
        return view('admin.colaborador', compact('servidores', 'lotacoes', 'vinculos'));
    }

    // 🔥 MÉTODO CREATE (ADICIONAR)
    public function create()
    {
        $lotacoes = Lotacao::where('status', true)->get();
        $vinculos = Vinculo::all();
        $perfis = Perfil::all();
        
        return view('servidor.colaboradores.create', compact('lotacoes', 'vinculos', 'perfis'));
    }

    // 🔥 MÉTODO STORE (ADICIONAR)
    public function store(Request $request)
    {
        try {
            // Validação dos dados
            $validated = $request->validate([
                'matricula' => 'required|unique:servidores',
                'nome_completo' => 'required',
                'cpf' => 'required|unique:servidores',
                'rg' => 'required',
                // ... adicione outras validações conforme necessário
            ]);

            // Criação do servidor
            $servidor = Servidor::create($validated);

            return redirect()->route('servidores.index')
                ->with('success', 'Colaborador cadastrado com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao cadastrar colaborador: ' . $e->getMessage());
        }
    }

    // 🔥 MÉTODO DESTROY (ADICIONAR)
    public function destroy($id)
    {
        try {
            $servidor = Servidor::findOrFail($id);
            
            // Deletar foto se existir
            if ($servidor->foto && Storage::disk('public')->exists($servidor->foto)) {
                Storage::disk('public')->delete($servidor->foto);
            }
            
            $servidor->delete();

            return redirect()->route('servidores.index')
                ->with('success', 'Servidor deletado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->route('servidores.index')
                ->with('error', 'Erro ao deletar servidor: ' . $e->getMessage());
        }
    }
    

    public function show($id)
    {
        $servidor = Servidor::findOrFail($id);
        return view('servidor.colaboradores.show', compact('servidor'));
    }

    public function edit($id)
    {
        $servidor = Servidor::findOrFail($id);
        $lotacoes = Lotacao::where('status', true)->get();
        $vinculos = Vinculo::all();
        $perfis = Perfil::all();
        
        return view('servidor.colaboradores.edit', compact('servidor', 'lotacoes', 'vinculos', 'perfis'));
    }

    public function update(Request $request, $id)
    {

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
        
        try {
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

            return redirect()->route('servidores.index')
                ->with('success', 'Servidor atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar servidor: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function dashboard()
    {
        $user = Auth::user();
        return view('servidor.colaborador.dashboard', compact('user'));
    }

    // 🔥 MÉTODO PERFIL (ADICIONAR)
    public function perfil()
    {
        $user = Auth::user();
        return view('admin.perfis-acesso', compact('user'));
    }
}