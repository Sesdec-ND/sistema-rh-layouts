<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RHController;
use App\Http\Controllers\Admin\DiretorController;
use App\Http\Controllers\Admin\ColaboradorController;
use App\Http\Controllers\ServidorController;
use Illuminate\Support\Facades\Auth;
use App\Models\Perfil;
use App\Http\Controllers\Pessoal\PerfilPessoalController;
use App\Http\Controllers\Admin\PerfisAcessoController;
use App\Http\Controllers\Admin\ConfiguracoesSistemaController;
use App\Http\Controllers\Admin\SegurancaController;
use App\Http\Controllers\Admin\CadastroColaboradorController;

// Rotas Públicas
Route::get('/', function () {
    return view('welcome');
});

Route::get('/area-protegida', function () {
    return view('area_protegida');
})->middleware('check.perfil: RH, Diretor Executivo, Colaborador');

// Listagem e criação servidores cadastrados
Route::post('/servidores', [ServidorController::class, 'store'])->name('servidor.store');
Route::get('/servidores/create', [ServidorController::class, 'create'])->name('servidores.create');
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
        // Dashboard e recursos básicos
        Route::get('/dashboard', [RHController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/colaboradores', [RHController::class, 'colaboradores'])->name('admin.colaborador');
        Route::get('/relatorios', [RHController::class, 'relatorios'])->name('admin.relatorios');
        
        // Perfis de Acesso
        Route::get('/perfis-acesso', [PerfisAcessoController::class, 'index'])->name('admin.perfis-acesso');
        Route::get('/perfis-acesso/{id}/edit', [PerfisAcessoController::class, 'edit'])->name('admin.perfis-acesso.edit');
        Route::put('/perfis-acesso/{id}', [PerfisAcessoController::class, 'update'])->name('admin.perfis-acesso.update');
        Route::get('/perfis-acesso/{id}/permissoes', [PerfisAcessoController::class, 'managePermissions'])->name('admin.perfis-acesso.permissoes');
        Route::put('/perfis-acesso/{id}/permissoes', [PerfisAcessoController::class, 'updatePermissions'])->name('admin.perfis-acesso.permissoes.update');
        
        // Configurações do Sistema
        Route::get('/configuracoes-sistema', [ConfiguracoesSistemaController::class, 'index'])->name('admin.configuracoes-sistema');
        Route::post('/configuracoes-sistema', [ConfiguracoesSistemaController::class, 'update'])->name('admin.configuracoes-sistema.update');
        
        // Segurança
        Route::get('/seguranca', [SegurancaController::class, 'index'])->name('admin.seguranca');
        Route::get('/seguranca/politicas', [SegurancaController::class, 'politicas'])->name('admin.seguranca.politicas');
        Route::post('/seguranca/politicas', [SegurancaController::class, 'updatePoliticas'])->name('admin.seguranca.politicas.update');
        Route::get('/seguranca/logs', [SegurancaController::class, 'logs'])->name('admin.seguranca.logs');
        Route::get('/seguranca/auditoria', [SegurancaController::class, 'auditoria'])->name('admin.seguranca.auditoria');
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

// Perfil Pessoal - Acesso universal para usuários logados
Route::middleware('auth')->prefix('meu-perfil')->name('perfil-pessoal.')->group(function () {
    Route::get('/', [PerfilPessoalController::class, 'show'])->name('show');
    Route::get('/editar', [PerfilPessoalController::class, 'edit'])->name('edit');
    Route::put('/atualizar', [PerfilPessoalController::class, 'update'])->name('update');
    Route::get('/documentos', [PerfilPessoalController::class, 'documentos'])->name('documentos');
    Route::get('/contracheque', [PerfilPessoalController::class, 'contracheque'])->name('contracheque');
});