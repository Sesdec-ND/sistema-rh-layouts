<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove apenas as colunas que existem
            if (Schema::hasColumn('users', 'cpf')) {
                $table->dropColumn('cpf');
            }
            if (Schema::hasColumn('users', 'rg')) {
                $table->dropColumn('rg');
            }
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'senha')) {
                $table->dropColumn('senha');
            }
            if (Schema::hasColumn('users', 'perfil_id')) {
                $table->dropColumn('perfil_id');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remover APENAS as colunas que existem
            $columnsToDrop = [];

            $possibleColumns = [
                'cpf',
                'rg',
                'username',
                'senha',
                'perfil_id'
            ];

            foreach ($possibleColumns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $columnsToDrop[] = $column;
                }
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
