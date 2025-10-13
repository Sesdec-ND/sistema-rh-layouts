<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RHController;
use App\Http\Controllers\Admin\DiretorController;
use App\Http\Controllers\Admin\ColaboradorController;
use App\Http\Controllers\ServidorController;
use Illuminate\Support\Facades\Auth;
use App\Models\Perfil;


// Rotas Públicas
Route::get('/', function () {
    return view('welcome');
});

Route::resource('servidores', ServidorController::class); //Rota cadastro de servidores

Route::get('/area-protegida', function () {
    return view('area_protegida');
})->middleware('check.perfil'); // <-- USANDO O ALIAS AQUI!

// Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas do RH
Route::prefix('rh')->middleware(['auth', 'check.perfil:RH'])->group(function () {
    Route::get('/dashboard', [RhController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/colaboradores', [RhController::class, 'colaboradores'])->name('admin.colaborador');
    Route::get('/relatorios', [RhController::class, 'relatorios'])->name('admin.relatorios');
});

// Rotas do Diretor
Route::prefix('diretor')->middleware(['auth', 'check.perfil:Diretor Executivo'])->group(function () {
    Route::get('/dashboard', [DiretorController::class, 'dashboard'])->name('diretor.dashboard');
    Route::get('/colaboradores', [DiretorController::class, 'visualizarColaboradores'])->name('diretor.colaboradores');
    
});

// Rotas do Colaborador
Route::prefix('colaborador')->middleware(['auth', 'check.perfil:Colaborador'])->group(function () {
    Route::get('/dashboard', [ColaboradorController::class, 'dashboard'])->name('colaborador.dashboard');
    Route::get('/perfil', [ColaboradorController::class, 'perfil'])->name('colaborador.perfil');
});

// Rota padrão após login
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user->perfil) {
        return redirect('/login');
    }
    
    return match($user->perfil->nomePerfil) {
        'RH' => redirect()->route('admin.dashboard'),
        'Diretor Executivo' => redirect()->route('diretor.dashboard'),
        'Colaborador' => redirect()->route('colaborador.dashboard'),
        default => redirect('/')
    };
})->middleware('auth')->name('dashboard');
