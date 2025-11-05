<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('servidores', function (Blueprint $table) {
            // Verifica se a coluna email já existe antes de adicionar
            if (!Schema::hasColumn('servidores', 'email')) {
                $table->string('email')
                      ->unique()
                      ->nullable()
                      ->after('nome_completo'); // Coloca após o nome_completo
                
                // Se quiser adicionar um índice para melhor performance:
                // $table->index('email');
            }
        });
    }

    public function down()
    {
        Schema::table('servidores', function (Blueprint $table) {
            // Remove a coluna email se existir
            if (Schema::hasColumn('servidores', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};