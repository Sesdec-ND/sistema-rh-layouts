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
        // Tabelas que precisam ser corrigidas
        $tabelas = ['dependentes', 'ocorrencias', 'historicos_pagamento', 'ferias'];
        
        foreach ($tabelas as $tabela) {
            // 1. Remover a foreign key antiga usando SQL direto
            $constraints = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = ? 
                AND REFERENCED_TABLE_NAME = 'servidores'
            ", [$tabela]);
            
            foreach ($constraints as $constraint) {
                DB::statement("ALTER TABLE {$tabela} DROP FOREIGN KEY {$constraint->CONSTRAINT_NAME}");
            }
            
            // 2. Criar coluna temporária
            DB::statement("ALTER TABLE {$tabela} ADD COLUMN id_servidor_new BIGINT UNSIGNED NULL AFTER id_servidor");
            
            // 3. Preencher a nova coluna com os IDs correspondentes
            DB::statement("
                UPDATE {$tabela} s
                INNER JOIN servidores serv ON serv.matricula = s.id_servidor
                SET s.id_servidor_new = serv.id
            ");
            
            // 4. Remover a coluna antiga
            DB::statement("ALTER TABLE {$tabela} DROP COLUMN id_servidor");
            
            // 5. Renomear a nova coluna
            DB::statement("ALTER TABLE {$tabela} CHANGE id_servidor_new id_servidor BIGINT UNSIGNED NOT NULL");
            
            // 6. Criar a nova foreign key
            DB::statement("
                ALTER TABLE {$tabela} 
                ADD CONSTRAINT {$tabela}_id_servidor_foreign 
                FOREIGN KEY (id_servidor) REFERENCES servidores(id) 
                ON DELETE CASCADE
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tabelas = ['dependentes', 'ocorrencias', 'historicos_pagamento', 'ferias'];
        
        foreach ($tabelas as $tabela) {
            // Remover foreign key
            $constraints = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = ? 
                AND REFERENCED_TABLE_NAME = 'servidores'
            ", [$tabela]);
            
            foreach ($constraints as $constraint) {
                DB::statement("ALTER TABLE {$tabela} DROP FOREIGN KEY {$constraint->CONSTRAINT_NAME}");
            }
            
            // Converter de volta para string
            DB::statement("ALTER TABLE {$tabela} ADD COLUMN id_servidor_new VARCHAR(255) NULL AFTER id_servidor");
            
            DB::statement("
                UPDATE {$tabela} s
                INNER JOIN servidores serv ON serv.id = s.id_servidor
                SET s.id_servidor_new = serv.matricula
            ");
            
            DB::statement("ALTER TABLE {$tabela} DROP COLUMN id_servidor");
            DB::statement("ALTER TABLE {$tabela} CHANGE id_servidor_new id_servidor VARCHAR(255) NOT NULL");
            
            DB::statement("
                ALTER TABLE {$tabela} 
                ADD CONSTRAINT {$tabela}_id_servidor_foreign 
                FOREIGN KEY (id_servidor) REFERENCES servidores(matricula) 
                ON DELETE CASCADE
            ");
        }
    }
};

