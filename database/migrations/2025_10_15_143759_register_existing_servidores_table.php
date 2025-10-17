<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Verifica se a tabela existe
        if (Schema::hasTable('servidores')) {
            // Adiciona apenas as colunas que podem estar faltando
            Schema::table('servidores', function (Blueprint $table) {
                if (!Schema::hasColumn('servidores', 'deleted_at')) {
                    $table->softDeletes(); // Adiciona deleted_at se não existir
                }
                if (!Schema::hasColumn('servidores', 'created_at')) {
                    $table->timestamps(); // Adiciona created_at e updated_at se não existirem
                }
            });
        } else {
            // Se a tabela não existir, cria (fallback)
            Schema::create('servidores', function (Blueprint $table) {
                $table->id();
                $table->string('nome_completo');
                $table->string('matricula')->unique();
                $table->string('cpf', 14)->unique();
                $table->string('formacao')->nullable();
                $table->string('telefone')->nullable();
                $table->string('id_vinculo')->nullable();
                $table->string('id_lotacao')->nullable();
                $table->string('foto')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        // Não dropa a tabela na rollback, pois ela já existia
        Schema::table('servidores', function (Blueprint $table) {
            if (Schema::hasColumn('servidores', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};