<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perfil;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin;

class RhController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->hasPermission('dashboard')) {
                abort(403, 'Acesso não autorizado');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $totalColaboradores = User::count();
        $totalPerfis = Perfil::count();
        
        return view('admin.dashboard', compact('totalColaboradores', 'totalPerfis'));
    }

    public function colaboradores()
    {
        if (!Auth::user()->hasPermission('colaboradores', 'view')) {
            abort(403, 'Acesso não autorizado');
        }

        $colaboradores = User::with('perfil')->get();
        return view('admin.colaborador', compact('colaboradores'));
    }

    public function relatorios()
    {
        if (!Auth::user()->hasPermission('relatorios')) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.relatorios');
    }
}