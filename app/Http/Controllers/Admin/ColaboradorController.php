<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servidor; // ← ADICIONE ESTA LINHA
use Illuminate\Support\Facades\Auth;
use App\Models\Lotacao;
use App\Models\Vinculo;

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

    public function dashboard()
    {
        $user = Auth::user();

        return view('servidor.colaborador.dashboard', compact('user'));
    }

    public function show($id)
    {
        $servidor = Servidor::findOrFail($id);

        return view('servidor.colaboradores.show', compact('servidor'));
    }

    public function edit($id)
    {
        $servidor = Servidor::findOrFail($id);

        return view('servidor.colaboradores.edit', compact('servidor'));
    }
}
