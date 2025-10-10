<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perfil;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiretorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->perfil->nomePerfil !== 'Diretor Executivo') {
                abort(403, 'Acesso não autorizado');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $totalColaboradores = User::count();
        return view('diretor.dashboard', compact('totalColaboradores'));
    }

    public function visualizarColaboradores()
    {
        $colaboradores = User::with('perfil')->get();
        return view('diretor.colaboradores', compact('colaboradores'));
    }
}
