<?php

namespace App\Http\Controllers;

use App\Models\Servidor; // Importe seu modelo Servidor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Para salvar a foto

class ServidorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Aqui você listaria todos os servidores.
        // Ex: $servidores = Servidor::all();
        // return view('servidores.index', compact('servidores'));
        
        // Por enquanto, vamos apenas redirecionar para a página de criação para teste
        return redirect()->route('servidores.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Aqui você pode buscar dados para os selects, como Vínculos e Lotações
        // Ex: $vinculos = Vinculo::all();
        //     $lotacoes = Lotacao::all();
        // return view('servidores.create', compact('vinculos', 'lotacoes'));

        return view('servidor.colaboradores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. VALIDAÇÃO DOS DADOS (backend)
        $validatedData = $request->validate([
            'matricula'      => 'required|string|max:20|unique:servidores,matricula',
            'nomeCompleto'   => 'required|string|max:255',
            'cpf'            => 'required|string|max:14|unique:servidores,cpf',
            'rg'             => 'required|string|max:20|unique:servidores,rg',
            'dataNascimento' => 'required|date',
            'genero'         => 'required|string',
            'estadoCivil'    => 'required|string',
            'telefone'       => 'nullable|string|max:20',
            'endereco'       => 'nullable|string|max:255',
            'formacao'       => 'required|string|max:100',
            'racaCor'        => 'nullable|string|max:50',
            'tipoSanguineo'  => 'nullable|string|max:5',
            'pisPasep'       => 'required|string|max:20|unique:servidores,pisPasep',
            'dataNomeacao'   => 'required|date',
            'idVinculo'      => 'required|integer|exists:vinculos,id', // Valida se o vínculo existe na tabela 'vinculos'
            'idLotacao'      => 'required|integer|exists:lotacoes,id', // Valida se a lotação existe na tabela 'lotacoes'
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Foto opcional, max 2MB
        ]);

        // 2. TRATAMENTO DO UPLOAD DA FOTO
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/fotos_servidores');
            // Salva apenas o caminho relativo no banco
            $validatedData['foto'] = Storage::url($path);
        }

        // Adiciona o status padrão como 'true' (ativo)
        $validatedData['status'] = true;

        // 3. CRIAÇÃO DO REGISTRO NO BANCO
        Servidor::create($validatedData);

        // 4. REDIRECIONAMENTO COM MENSAGEM DE SUCESSO
        return redirect()->route('servidores.index') // ou para onde você preferir
                         ->with('success', 'Servidor cadastrado com sucesso!');
    }

    // ... outros métodos do resource (show, edit, update, destroy)
}
