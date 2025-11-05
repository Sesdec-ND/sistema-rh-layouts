<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('servidores', function (Blueprint $table) {
            // Verificar se ambos os campos existem
            if (Schema::hasColumn('servidores', 'pis_pasep') && Schema::hasColumn('servidores', 'pispasep')) {
                
                // Migrar dados do campo antigo para o novo (se houver dados no campo antigo)
                DB::statement('UPDATE servidores SET pispasep = pis_pasep WHERE pispasep IS NULL AND pis_pasep IS NOT NULL');
                
                // Remover o campo duplicado antigo
                $table->dropColumn('pis_pasep');
            }
        });
    }

    public function down()
    {
        Schema::table('servidores', function (Blueprint $table) {
            // Em caso de rollback, recriar o campo antigo
            if (!Schema::hasColumn('servidores', 'pis_pasep')) {
                $table->string('pis_pasep', 20)->nullable()->after('tipo_sanguineo');
                
                // Migrar dados de volta se necessário
                DB::statement('UPDATE servidores SET pis_pasep = pispasep');
            }
        });
    }
};