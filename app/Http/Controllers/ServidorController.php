<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ServidorController extends Controller
{
    public function index()
    {
        {
    // Verifica se o usuário é RH (administrador)
    if (Auth::user()->tipo !== 'rh') {
        return redirect()->route('dashboard')->with('error', 'Acesso não autorizado.');
    }

    $servidores = Servidor::all();
    return view('servidores.index', compact('servidores'));
}
        $servidores = Servidor::latest()->paginate(10);

        return view('servidor.colaboradores.index', compact('servidores'));
    }

    public function create()
    {
        return view('servidor.colaboradores.create');
    }

    public function store(Request $request)
    {
        // Validação dos dados principais
        $validated = $request->validate([
        'matricula' => 'required|max:20|unique:servidores,matricula,' . $servidor->id,
        'nomeCompleto' => 'required|max:255',
        'cpf' => 'required|max:14|unique:servidores,cpf,' . $servidor->id,
        'rg' => 'required|max:20',
        'dataNascimento' => 'required|date',
        'genero' => 'required|in:Masculino,Feminino',
        'estadoCivil' => 'required',
        'telefone' => 'required|max:20',
        'endereco' => 'required|max:500',
        'racaCor' => 'required',
        'tipoSanguineo' => 'required',
        'foto' => 'nullable|image|max:2048',
        'formacao' => 'required|max:255',
        'pisPasep' => 'required|max:50',
        'dataNomeacao' => 'required|date',
        'idVinculo' => 'required',
        'idLotacao' => 'required',
    ]);

        // Mapear nomes dos campos para o banco de dados
        $servidorData = [
        'matricula' => $validated['matricula'],
        'nome_completo' => $validated['nomeCompleto'],
        'cpf' => $validated['cpf'],
        'rg' => $validated['rg'],
        'data_nascimento' => $validated['dataNascimento'],
        'genero' => $validated['genero'],
        'estado_civil' => $validated['estadoCivil'],
        'telefone' => $validated['telefone'],
        'endereco' => $validated['endereco'],
        'raca_cor' => $validated['racaCor'],
        'tipo_sanguineo' => $validated['tipoSanguineo'],
        'formacao' => $validated['formacao'],
        'pis_pasep' => $validated['pisPasep'],
        'data_nomeacao' => $validated['dataNomeacao'],
        'id_vinculo' => $validated['idVinculo'],
        'id_lotacao' => $validated['idLotacao'],
    ];

        // Upload da foto
        if ($request->hasFile('foto')) {
        if ($servidor->foto) {
            Storage::disk('public')->delete($servidor->foto);
        }
        $servidorData['foto'] = $request->file('foto')->store('servidores', 'public');
    }

        // Criar servidor
        $servidor = Servidor::create($servidorData);

        // Processar dependentes se existirem
        $servidor = Servidor::create($request->except('dependentes'));

        // Processar dependentes
        if ($request->has('dependentes')) {
        // Primeiro remover todos os dependentes existentes
        $servidor->dependentes()->delete();
        
        // Depois adicionar os novos
        foreach ($request->dependentes as $dependenteData) {
            if (!empty($dependenteData['nome'])) {
                $servidor->dependentes()->create([
                    'nome' => $dependenteData['nome'],
                    'idade' => $dependenteData['idade'] ?? null,
                    'data_nascimento' => $dependenteData['data_nascimento'] ?? null,
                    'cpf' => $dependenteData['cpf'] ?? null,
                ]);
            }
            }
        }

        return redirect()->route('servidores.index')
            ->with('success', 'Servidor cadastrado com sucesso!');
    }

    public function show(Servidor $servidor)
    {
        return view('servidor.colaboradores.show', compact('servidor'));
    }

    public function edit(Servidor $servidor, $id)
    {
        {
    if (auth()->user()->tipo !== 'rh') {
        return redirect()->route('dashboard')->with('error', 'Acesso não autorizado.');
    }

    $servidor = Servidor::findOrFail($id);
    return view('servidores.edit', compact('servidor'));
}

        return view('servidor.colaboradores.edit', compact('servidor'));
    }

    public function update(Request $request, Servidor $servidor, $id)
    {
        {
    if (auth()->user()->tipo !== 'rh') {
        return redirect()->route('dashboard')->with('error', 'Acesso não autorizado.');
    }

    $servidor = Servidor::findOrFail($id);
    
    $request->validate([
        'nome' => 'required|string|max:255',
        'email' => 'required|email|unique:servidores,email,' . $id,
        // adicione outros campos conforme necessário
    ]);

    $servidor->update($request->all());

    return redirect()->route('servidores.index')->with('success', 'Servidor atualizado com sucesso!');
}
        $validated = $request->validate([
            'matricula' => 'required|max:20|unique:servidores,matricula,'.$servidor->id,
            'nomeCompleto' => 'required|max:255',
            'cpf' => 'required|max:14|unique:servidores,cpf,'.$servidor->id,
            'rg' => 'required|max:20',
            'dataNascimento' => 'required|date',
            'genero' => 'required|in:Masculino,Feminino',
            'estadoCivil' => 'required',
            'telefone' => 'required|max:20',
            'endereco' => 'required|max:500',
            'racaCor' => 'required',
            'tipoSanguineo' => 'required',
            'foto' => 'nullable|image|max:2048',
            'formacao' => 'required|max:255',
            'pisPasep' => 'required|max:50',
            'dataNomeacao' => 'required|date',
            'idVinculo' => 'required',
            'idLotacao' => 'required',
        ]);

        // Mapear dados
        $servidorData = [
            'matricula' => $validated['matricula'],
            'nome_completo' => $validated['nomeCompleto'],
            'cpf' => $validated['cpf'],
            'rg' => $validated['rg'],
            'data_nascimento' => $validated['dataNascimento'],
            'genero' => $validated['genero'],
            'estado_civil' => $validated['estadoCivil'],
            'telefone' => $validated['telefone'],
            'endereco' => $validated['endereco'],
            'raca_cor' => $validated['racaCor'],
            'tipo_sanguineo' => $validated['tipoSanguineo'],
            'formacao' => $validated['formacao'],
            'pis_pasep' => $validated['pisPasep'],
            'data_nomeacao' => $validated['dataNomeacao'],
            'id_vinculo' => $validated['idVinculo'],
            'id_lotacao' => $validated['idLotacao'],
        ];

        // Upload da foto
        if ($request->hasFile('foto')) {
            // Remove foto antiga
            if ($servidor->foto) {
                Storage::disk('public')->delete($servidor->foto);
            }
            $servidorData['foto'] = $request->file('foto')->store('servidores', 'public');
        }

        $servidor->update($servidorData);

        return redirect()->route('servidores.index')
            ->with('success', 'Servidor atualizado com sucesso!');
    }

    public function destroy(Servidor $servidor)
    {
        // Não deleta a foto aqui - soft delete mantém os dados
        $servidor->delete();

        return redirect()->route('servidores.index')
            ->with('success', 'Servidor removido com sucesso!');
    }

    public function trashed()
    {
        $servidores = Servidor::onlyTrashed()->latest()->paginate(10);

        return view('servidor.colaboradores.trashed', compact('servidores'));
    }

    public function restore($id)
    {
        $servidor = Servidor::onlyTrashed()->findOrFail($id);
        $servidor->restore();

        return redirect()->route('servidores.trashed')
            ->with('success', 'Servidor restaurado com sucesso!');
    }

    public function forceDelete($id)
    {
        $servidor = Servidor::onlyTrashed()->findOrFail($id);

        // Remove foto apenas na exclusão permanente
        if ($servidor->foto) {
            Storage::disk('public')->delete($servidor->foto);
        }

        $servidor->forceDelete();

        return redirect()->route('servidores.trashed')
            ->with('success', 'Servidor excluído permanentemente!');
    }
}
