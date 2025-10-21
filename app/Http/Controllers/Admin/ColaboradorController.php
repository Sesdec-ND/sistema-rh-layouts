<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Perfil;
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

    public function dashboard()
    {
        $user = Auth::user();
        return view('servidor.colaborador.dashboard', compact('user'));
    }

}
// public function perfil()
// {
//     $user = Auth::user();
//     return view('servidor.colaborador.perfil', compact('user'));
// }