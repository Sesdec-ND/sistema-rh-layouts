<?php

use App\Http\Controllers\Admin\ColaboradorController;
use App\Http\Controllers\Admin\ConfiguracoesSistemaController;
use App\Http\Controllers\Admin\DiretorController;
use App\Http\Controllers\Admin\PerfisAcessoController;
use App\Http\Controllers\Admin\RHController;
use App\Http\Controllers\Admin\SegurancaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pessoal\PerfilPessoalController;
use App\Http\Controllers\ServidorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Rotas Públicas
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rotas Protegidas
Route::middleware('auth')->group(function () {
    
    // Dashboard Principal
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if (!$user->perfil) return redirect('/');
        
        return match ($user->perfil->nomePerfil) {
            'RH' => redirect()->route('admin.dashboard'),
            'Diretor Executivo' => redirect()->route('diretor.dashboard'),
            'Colaborador' => redirect()->route('colaborador.dashboard'),
            default => redirect('/')
        };
    })->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Área do RH
    Route::prefix('rh')->middleware(['auth', 'check.perfil:RH'])->group(function () {
        
        // Dashboards
        Route::get('/dashboard', [RHController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/colaboradores', [RHController::class, 'colaboradores'])->name('admin.colaborador');
        Route::get('/relatorios', [RHController::class, 'relatorios'])->name('admin.relatorios');
        
        // Servidores (CRUD Completo)
        Route::prefix('servidores')->group(function () {
            Route::get('/', [ServidorController::class, 'index'])->name('servidores.index');
            Route::get('/create', [ServidorController::class, 'create'])->name('servidores.create');
            Route::post('/', [ServidorController::class, 'store'])->name('servidores.store');
            Route::get('/{id}', [ServidorController::class, 'show'])->name('servidores.show');
            Route::get('/{id}/edit', [ServidorController::class, 'edit'])->name('servidores.edit');
            Route::put('/{id}', [ServidorController::class, 'update'])->name('servidores.update');
            Route::delete('/{id}', [ServidorController::class, 'destroy'])->name('servidores.destroy');
            
            // Lixeira
            Route::get('/lixeira/listar', [ServidorController::class, 'lixeira'])->name('servidores.lixeira');
            Route::patch('/{id}/restore', [ServidorController::class, 'restore'])->name('servidores.restore');
            Route::delete('/{id}/force-delete', [ServidorController::class, 'forceDelete'])->name('servidores.force-delete');
            Route::delete('/empty-trash', [ServidorController::class, 'emptyTrash'])->name('servidores.empty-trash');
        });

        // Outras rotas do RH...
        Route::get('/perfis-acesso', [PerfisAcessoController::class, 'index'])->name('admin.perfis-acesso');
        Route::get('/configuracoes-sistema', [ConfiguracoesSistemaController::class, 'index'])->name('admin.configuracoes-sistema');
        Route::get('/seguranca', [SegurancaController::class, 'index'])->name('admin.seguranca');
    });

    // Área do Diretor
    Route::prefix('diretor')->middleware(['auth', 'check.perfil:Diretor Executivo'])->group(function () {
        Route::get('/dashboard', [DiretorController::class, 'dashboard'])->name('diretor.dashboard');
        Route::get('/colaboradores', [DiretorController::class, 'visualizarColaboradores'])->name('diretor.colaboradores');
    });

    // Área do Colaborador
    Route::prefix('colaborador')->middleware(['auth', 'check.perfil:Colaborador'])->group(function () {
        Route::get('/dashboard', [ColaboradorController::class, 'dashboard'])->name('colaborador.dashboard');
        Route::get('/perfil', [ColaboradorController::class, 'perfil'])->name('colaborador.perfil');
    });

    // Perfil Pessoal
    Route::prefix('meu-perfil')->name('perfil-pessoal.')->group(function () {
        Route::get('/', [PerfilPessoalController::class, 'show'])->name('show');
        Route::get('/editar', [PerfilPessoalController::class, 'edit'])->name('edit');
    });
});