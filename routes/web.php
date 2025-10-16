<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RhController;
use App\Http\Controllers\Admin\DiretorController;
use App\Http\Controllers\Admin\ColaboradorController;
use App\Http\Controllers\ServidorController;
use Illuminate\Support\Facades\Auth;
use App\Models\Perfil;

// Rotas Públicas
Route::get('/', function () {
    return view('welcome');
});

// Route::get('/area-protegida', function () {
//     return view('area_protegida');
// })->middleware('check.perfil'); // <-- USANDO O ALIAS AQUI!

// Listagem de servidores cadastrados
Route::get('/servidores', [ServidorController::class, 'index'])->name('servidores.index');
Route::get('/servidores/{id}/edit', [ServidorController::class, 'edit'])->name('servidores.edit');
Route::put('/servidores/{id}', [ServidorController::class, 'update'])->name('servidores.update');

// Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// INÍCIO DO GRUPO DE ROTAS PROTEGIDAS
Route::middleware('auth')->group(function () {
    
    // Rota padrão após login
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if (!$user->perfil) {
            return redirect('/');
        }
        
        return match($user->perfil->nomePerfil) {
            'RH' => redirect()->route('admin.dashboard'),
            'Diretor Executivo' => redirect()->route('diretor.dashboard'),
            'Colaborador' => redirect()->route('colaborador.dashboard'),
            default => redirect('/')
        };
    })->name('dashboard');

// Rotas do Admin (RH) - Views na pasta admin/
Route::prefix('rh')->middleware(['auth', 'check.perfil:RH'])->group(function () {
    Route::get('/dashboard', [RhController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/colaboradores', [RhController::class, 'colaboradores'])->name('admin.colaborador');
    Route::get('/relatorios', [RhController::class, 'relatorios'])->name('admin.relatorios');
});

// Rotas do Diretor - Views na pasta servidor/diretor/
Route::prefix('diretor')->middleware(['auth', 'check.perfil:Diretor Executivo'])->group(function () {
    Route::get('/dashboard', [DiretorController::class, 'dashboard'])->name('diretor.dashboard');
    Route::get('/colaboradores', [DiretorController::class, 'visualizarColaboradores'])->name('diretor.colaboradores');
});

// Rotas do Colaborador - Views na pasta servidor/colaborador/
Route::prefix('colaborador')->middleware(['auth', 'check.perfil:Colaborador'])->group(function () {
    Route::get('/dashboard', [ColaboradorController::class, 'dashboard'])->name('colaborador.dashboard');
    Route::get('/perfil', [ColaboradorController::class, 'perfil'])->name('colaborador.perfil');
});

// Rota de logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
<<<<<<< HEAD
=======

    // Rotas para Servidores com middleware de autenticação
Route::middleware(['auth'])->group(function () {
    // Rotas principais de servidores
    Route::get('/servidores', [ServidorController::class, 'index'])->name('servidores.index');
    Route::get('/servidores/create', [ServidorController::class, 'create'])->name('servidores.create');
    Route::post('/servidores', [ServidorController::class, 'store'])->name('servidores.store');
    Route::get('/servidores/{servidor}', [ServidorController::class, 'show'])->name('servidores.show');
    Route::get('/servidores/{servidor}/edit', [ServidorController::class, 'edit'])->name('servidores.edit');
    Route::put('/servidores/{servidor}', [ServidorController::class, 'update'])->name('servidores.update');
    Route::delete('/servidores/{servidor}', [ServidorController::class, 'destroy'])->name('servidores.destroy');
    
    // Rotas para lixeira (soft delete)
    Route::get('/servidores/trashed', [ServidorController::class, 'trashed'])->name('servidores.trashed');
    Route::patch('/servidores/{servidor}/restore', [ServidorController::class, 'restore'])->name('servidores.restore');
    Route::delete('/servidores/{servidor}/force-delete', [ServidorController::class, 'forceDelete'])->name('servidores.force-delete');
});

// // Se você quiser adicionar middleware específico para admin
// Route::middleware(['auth', 'admin'])->group(function () {
//     // Rotas administrativas aqui (se necessário)
// });
>>>>>>> 068e35f (Cadastro servidores)
