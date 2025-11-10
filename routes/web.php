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
            
            // Lixeira
            Route::get('/lixeira/listar', [ServidorController::class, 'lixeira'])->name('servidores.lixeira');
            Route::patch('/{id}/restore', [ServidorController::class, 'restore'])->name('servidores.restore');
            Route::delete('/{id}/force-delete', [ServidorController::class, 'forceDelete'])->name('servidores.force-delete');
            Route::delete('/empty-trash', [ServidorController::class, 'emptyTrash'])->name('servidores.empty-trash');
            
            // Dependentes
            Route::post('/{servidorId}/dependentes', [ServidorController::class, 'storeDependente'])->name('servidores.dependentes.store');
            Route::put('/{servidorId}/dependentes/{dependenteId}', [ServidorController::class, 'updateDependente'])->name('servidores.dependentes.update');
            Route::delete('/{servidorId}/dependentes/{dependenteId}', [ServidorController::class, 'destroyDependente'])->name('servidores.dependentes.destroy');
            
            // Ocorrências
            Route::post('/{servidorId}/ocorrencias', [ServidorController::class, 'storeOcorrencia'])->name('servidores.ocorrencias.store');
            Route::put('/{servidorId}/ocorrencias/{ocorrenciaId}', [ServidorController::class, 'updateOcorrencia'])->name('servidores.ocorrencias.update');
            Route::delete('/{servidorId}/ocorrencias/{ocorrenciaId}', [ServidorController::class, 'destroyOcorrencia'])->name('servidores.ocorrencias.destroy');
            
            // Pagamentos
            Route::post('/{servidorId}/pagamentos', [ServidorController::class, 'storePagamento'])->name('servidores.pagamentos.store');
            Route::put('/{servidorId}/pagamentos/{pagamentoId}', [ServidorController::class, 'updatePagamento'])->name('servidores.pagamentos.update');
            Route::delete('/{servidorId}/pagamentos/{pagamentoId}', [ServidorController::class, 'destroyPagamento'])->name('servidores.pagamentos.destroy');
            
            // Férias
            Route::post('/{servidorId}/ferias', [ServidorController::class, 'storeFeria'])->name('servidores.ferias.store');
            Route::put('/{servidorId}/ferias/{feriaId}', [ServidorController::class, 'updateFeria'])->name('servidores.ferias.update');
            Route::delete('/{servidorId}/ferias/{feriaId}', [ServidorController::class, 'destroyFeria'])->name('servidores.ferias.destroy');
            
            // Visualização para Impressão/PDF
            Route::get('/{id}/imprimir', [ServidorController::class, 'print'])->name('servidores.print');
        });
        
        // Lotacoes
        Route::prefix('lotacoes')->group(function () {
            Route::put('/{id}', [ServidorController::class, 'updateLotacao'])->name('lotacoes.update');
        });

        // Rotas de Relatórios
        Route::prefix('relatorios')->group(function () {
        Route::get('/', [RelatoriosController::class, 'index'])->name('admin.relatorios.index');
        Route::get('/colaboradores', [RelatoriosController::class, 'relatorioColaboradores'])->name('admin.relatorios.colaboradores');
        Route::get('/analitico', [RelatoriosController::class, 'relatorioAnalitico'])->name('admin.relatorios.analitico');
        Route::get('/folha-pagamento', [RelatoriosController::class, 'relatorioFolhaPagamento'])->name('admin.relatorios.folha-pagamento');
        Route::get('/performance', [RelatoriosController::class, 'relatorioPerformance'])->name('admin.relatorios.performance');
        Route::get('/gerados', [RelatoriosController::class, 'relatoriosGerados'])->name('admin.relatorios.gerados');
        });

        // Acesso ao Sistema (nova seção)
        Route::get('/acesso-sistema', [UsuarioController::class, 'indexAcessoSistema'])->name('admin.acesso-sistema');
        Route::get('/acesso-sistema/atribuir/{servidor}', [UsuarioController::class, 'createUserFromServidor'])->name('admin.acesso-sistema.atribuir');
        Route::post('/acesso-sistema/criar-usuario/{servidor}', [UsuarioController::class, 'storeUserFromServidor'])->name('admin.acesso-sistema.criar-usuario');
        Route::put('/acesso-sistema/atualizar-perfil/{user}', [UsuarioController::class, 'updateUserPerfil'])->name('admin.acesso-sistema.atualizar-perfil');
        Route::post('/acesso-sistema/revogar-acesso/{user}', [UsuarioController::class, 'revogarAcesso'])->name('admin.acesso-sistema.revogar');

        // Outras rotas do RH...
        Route::get('/perfis-acesso', [PerfisAcessoController::class, 'index'])->name('admin.perfis-acesso');
        Route::get('/configuracoes-sistema', [ConfiguracoesSistemaController::class, 'index'])->name('admin.configuracoes-sistema');

        // Segurança (ROTAS CORRIGIDAS)
        Route::prefix('seguranca')->group(function () {
            Route::get('/', [SegurancaController::class, 'index'])->name('admin.seguranca');
            Route::get('/politicas', [SegurancaController::class, 'politicas'])->name('admin.seguranca.politicas');
            Route::get('/logs', [SegurancaController::class, 'logs'])->name('admin.seguranca.logs');
            Route::get('/auditoria', [SegurancaController::class, 'auditoria'])->name('admin.seguranca.auditoria');
            Route::put('/politicas', [SegurancaController::class, 'updatePoliticas'])->name('admin.seguranca.update-politicas');
        });
    });

    // Área do Diretor
    Route::prefix('diretor')->middleware(['auth', 'check.perfil:Diretor Executivo'])->group(function () {
        Route::get('/dashboard', [DiretorController::class, 'dashboard'])->name('diretor.dashboard');
        Route::get('/colaboradores', [DiretorController::class, 'visualizarColaboradores'])->name('diretor.colaboradores');
    });

    // Área do Colaborador
    Route::prefix('colaborador')->middleware(['auth', 'check.perfil:Colaborador'])->group(function () {
        Route::get('/dashboard', [ColaboradorController::class, 'dashboard'])->name('colaborador.dashboard');
    });

    // Perfil Pessoal
    Route::prefix('meu-perfil')->name('perfil-pessoal.')->group(function () {
        Route::get('/', [PerfilPessoalController::class, 'show'])->name('show');
        Route::get('/editar', [PerfilPessoalController::class, 'edit'])->name('edit');
        Route::put('/atualizar', [PerfilPessoalController::class, 'update'])->name('update');
        Route::get('/documentos', [PerfilPessoalController::class, 'documentos'])->name('documentos');
        Route::get('/contracheque', [PerfilPessoalController::class, 'contracheque'])->name('contracheque');
    });
});