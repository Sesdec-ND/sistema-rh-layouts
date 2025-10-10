<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Perfil;

class CheckPerfil
{
    public function handle(Request $request, Closure $next, ...$perfis) : Response //response foi adicionado
    {
        $user = Auth::user();
        
        if (!$user) {
        abort(403, 'Usuário não autenticado');
    }

    if (!$user->perfil) {
        abort(403, 'Perfil não atribuído ao usuário');
    }

    if (!in_array($user->perfil->nomePerfil, $perfis)) {
        abort(403, 'Acesso não autorizado para este perfil');
    }

    return $next($request);
    }
}
