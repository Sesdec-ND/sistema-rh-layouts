<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('servidores', function (Blueprint $table) {
            // Verificar se a coluna existe e é do tipo ENUM
            $columnType = DB::select("SHOW COLUMNS FROM servidores WHERE Field = 'raca_cor'");
            
            if (!empty($columnType)) {
                $type = $columnType[0]->Type;
                
                // Se for ENUM, alterar para string
                if (strpos($type, 'enum') !== false || strpos($type, 'ENUM') !== false) {
                    // Primeiro, alterar para string temporariamente
                    DB::statement("ALTER TABLE servidores MODIFY COLUMN raca_cor VARCHAR(50) NULL");
                } else {
                    // Se já for string, apenas garantir que tem tamanho suficiente
                    DB::statement("ALTER TABLE servidores MODIFY COLUMN raca_cor VARCHAR(50) NULL");
                }
            } else {
                // Se a coluna não existir, criar como string
                $table->string('raca_cor', 50)->nullable()->after('endereco');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Não precisamos reverter, mas podemos deixar como estava
        Schema::table('servidores', function (Blueprint $table) {
            // Opcional: reverter para ENUM se necessário
            // DB::statement("ALTER TABLE servidores MODIFY COLUMN raca_cor ENUM('Branca', 'Preta', 'Parda', 'Amarela') NULL");
        });
    }
};
