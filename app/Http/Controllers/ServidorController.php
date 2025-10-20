<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServidorController extends Controller
{
    public function index()
    {

        // Verifica se o usuário é RH (administrador)
        if (auth()->user()->tipo !== 'rh') {
            return redirect()->route('dashboard')->with('error', 'Acesso não autorizado.');
        }

        $servidores = Servidor::all();

        return view('servidor.colaboradores.index', compact('servidores'));

        $servidores = Servidor::latest()->paginate(10);

        return view('servidor.colaboradores.index', compact('servidores'));
    }

    public function create()
    {
        return view('servidor.colaboradores.create');
    }

    public function store(Request $request)
    {
        // Validação (os nomes aqui são os do formulário, em camelCase)
        $validated = $request->validate([
            'matricula' => 'required|max:20|unique:servidores',
            'nomeCompleto' => 'required|max:255',
            'cpf' => 'required|max:14|unique:servidores',
            'rg' => 'required|max:20',
            'dataNascimento' => 'required|date',
            'genero' => 'required|in:Masculino,Feminino,Outro',
            'estadoCivil' => 'required',
            'telefone' => 'nullable|max:20',
            'endereco' => 'nullable|max:500',
            'racaCor' => 'nullable',
            'tipoSanguineo' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'formacao' => 'nullable|string|max:255',
            'pisPasep' => 'nullable|string|max:50',
            'dataNomeacao' => 'nullable|date',
            'idVinculo' => 'nullable|string|max:50',
            'idLotacao' => 'nullable|string|max:50',
            'dependentes' => 'nullable|array',
            'dependentes.*.nome' => 'required_with:dependentes|string|max:255',
            'dependentes.*.data_nascimento' => 'required_with:dependentes|date',
            'dependentes.*.cpf' => 'nullable|string|max:14',
        ]);

        // Mapeia os nomes do formulário (camelCase) para os nomes do banco (snake_case)
        $servidorData = [
            'matricula' => $validated['matricula'],
            'nome_completo' => $validated['nomeCompleto'],
            'cpf' => $validated['cpf'],
            'rg' => $validated['rg'],
            'data_nascimento' => $validated['dataNascimento'],
            'genero' => $validated['genero'],
            'estado_civil' => $validated['estadoCivil'],
            'telefone' => $validated['telefone'] ?? null,
            'endereco' => $validated['endereco'] ?? null,
            'raca_cor' => $validated['racaCor'] ?? null,
            'tipo_sanguineo' => $validated['tipoSanguineo'] ?? null,
            'formacao' => $validated['formacao'] ?? null,
            'pis_pasep' => $validated['pisPasep'] ?? null,
            'data_nomeacao' => $validated['dataNomeacao'] ?? null,
            'id_vinculo' => $validated['idVinculo'] ?? null,
            'id_lotacao' => $validated['idLotacao'] ?? null,
        ];

        DB::beginTransaction();
        try {
            // Upload da foto
            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('servidores', 'public');
                $servidorData['foto'] = $path; // Salva o caminho relativo
            }

            // Cria o servidor (agora vai funcionar por causa do $fillable no Model)
            $servidor = Servidor::create($servidorData);

            // Salva os dependentes
            if (isset($validated['dependentes'])) {
                $servidor->dependentes()->createMany($validated['dependentes']);
            }

            DB::commit();

            return redirect()->route('dashboard')
            ->with('success', 'Servidor cadastrado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Falha ao cadastrar o servidor: '.$e->getMessage())->withInput();
        }
    }

    public function show(Servidor $servidor)
    {
        return view('servidor.colaboradores.show', compact('servidor'));
    }

    public function edit(Servidor $servidor, $id)
    {

        if (auth()->user()->tipo !== 'rh') {
            return redirect()->route('dashboard')->with('error', 'Acesso não autorizado.');
        }

        $servidor = Servidor::findOrFail($id);

        return view('servidor.colaboradores.edit', compact('servidor'));

        return view('servidor.colaboradores.edit', compact('servidor'));
    }

    public function update(Request $request, Servidor $servidor, $id)
    {

        if (auth()->user()->tipo !== 'rh') {
            return redirect()->route('dashboard')->with('error', 'Acesso não autorizado.');
        }

        $servidor = Servidor::findOrFail($id);

        $request->validate([
            'matricula' => 'required|max:20|unique:servidores,matricula,'.$servidor->id,
            'nomeCompleto' => 'required|max:255',
            'cpf' => 'required|max:14|unique:servidores,cpf,'.$servidor->id,
            // adicione outros campos conforme necessário
        ]);

        $servidor->update($request->all());

        return redirect()->route('servidores.index')->with('success', 'Servidor atualizado com sucesso!');

        $validated = $request->validate([
            'matricula' => 'required|max:20|unique:servidores,matricula,'.$servidor->id,
            'nomeCompleto' => 'required|max:255',
            'cpf' => 'required|max:14|unique:servidores,cpf,'.$servidor->id,
            'rg' => 'nullable|required|max:20',
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

        // return redirect()->route('servidor.trashed')
        //     ->with('success', 'Servidor restaurado com sucesso!');
    }

    public function forceDelete($id)
    {
        $servidor = Servidor::onlyTrashed()->findOrFail($id);

        // Remove foto apenas na exclusão permanente
        if ($servidor->foto) {
            Storage::disk('public')->delete($servidor->foto);
        }

        $servidor->forceDelete();

        // return redirect()->route('servidores.trashed')
        //     ->with('success', 'Servidor excluído permanentemente!');
    }
}
