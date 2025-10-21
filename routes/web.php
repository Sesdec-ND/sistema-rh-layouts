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
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\RelatoriosController;
use App\Models\Perfil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/area-protegida', function () {
    return view('area_protegida');
})->middleware('check.perfil: RH, Diretor Executivo, Colaborador');

// Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// INÍCIO DO GRUPO DE ROTAS PROTEGIDAS
Route::middleware('auth')->group(function () {

    // Rota padrão após login
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if (! $user->perfil) {
            return redirect('/');
        }

        return match ($user->perfil->nomePerfil) {
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
        // Route::get('/relatorios', [RHController::class, 'relatorios'])->name('admin.relatorios');

        // Servidores (CRUD Completo)
        Route::prefix('servidores')->group(function () {
        Route::get('/', [ServidorController::class, 'index'])->name('servidores.index');
        Route::get('/create', [ServidorController::class, 'create'])->name('servidores.create');
        Route::post('/', [ServidorController::class, 'store'])->name('servidores.store');
        Route::get('/{id}', [ServidorController::class, 'show'])->name('servidores.show');
        Route::get('/{id}/edit', [ServidorController::class, 'edit'])->name('servidores.edit');
        Route::put('/{id}', [ServidorController::class, 'update'])->name('servidores.update');
        Route::delete('/{id}', [ServidorController::class, 'destroy'])->name('servidores.destroy');
        });

        // Rotas de Relatórios
        Route::prefix('relatorios')->name('admin.relatorios.')->group(function () {
        Route::get('/', [RelatoriosController::class, 'index'])->name('index');
        Route::get('/colaboradores', [RelatoriosController::class, 'relatorioColaboradores'])->name('colaboradores');
        Route::get('/folha-pagamento', [RelatoriosController::class, 'relatorioFolhaPagamento'])->name('folha-pagamento');
        Route::get('/performance', [RelatoriosController::class, 'relatorioPerformance'])->name('performance');
        Route::get('/gerados', [RelatoriosController::class, 'relatoriosGerados'])->name('gerados');
        });

        // Acesso ao Sistema (nova seção)
        Route::get('/acesso-sistema', [UsuarioController::class, 'indexAcessoSistema'])->name('admin.acesso-sistema');
        Route::get('/acesso-sistema/atribuir/{servidor}', [UsuarioController::class, 'createUserFromServidor'])->name('admin.acesso-sistema.atribuir');
        Route::post('/acesso-sistema/criar-usuario/{servidor}', [UsuarioController::class, 'storeUserFromServidor'])->name('admin.acesso-sistema.criar-usuario');
        Route::put('/acesso-sistema/atualizar-perfil/{user}', [UsuarioController::class, 'updateUserPerfil'])->name('admin.acesso-sistema.atualizar-perfil');
        Route::post('/acesso-sistema/revogar-acesso/{user}', [UsuarioController::class, 'revogarAcesso'])->name('admin.acesso-sistema.revogar');

        // Perfis de Acesso
        Route::get('/perfis-acesso', [PerfisAcessoController::class, 'index'])->name('admin.perfis-acesso');
        Route::get('/perfis-acesso/{id}/edit', [PerfisAcessoController::class, 'edit'])->name('admin.perfis-acesso.edit');
        Route::put('/perfis-acesso/{id}', [PerfisAcessoController::class, 'update'])->name('admin.perfis-acesso.update');
        Route::get('/perfis-acesso/{id}/permissoes', [PerfisAcessoController::class, 'managePermissions'])->name('admin.perfis-acesso.permissoes');
        Route::post('/perfis-acesso/{id}/permissoes', [PerfisAcessoController::class, 'updatePermissions'])->name('admin.perfis-acesso.permissoes.update');

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
