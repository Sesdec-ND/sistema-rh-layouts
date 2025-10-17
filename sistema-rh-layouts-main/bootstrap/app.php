<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Adicionando o alias 'check.perfil' para o seu Middleware
        $middleware->alias([
            'check.perfil' => \App\Http\Middleware\CheckPerfil::class,
        ]);
        // Se você precisar adicionar Middlewares ao grupo 'web' ou 'api', 
        // você usaria os métodos ->appendToGroup() aqui.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
