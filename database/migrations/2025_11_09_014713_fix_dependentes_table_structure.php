<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dependentes', function (Blueprint $table) {
            // Adicionar coluna genero se não existir
            if (!Schema::hasColumn('dependentes', 'genero')) {
                $table->string('genero')->nullable()->after('cpf');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dependentes', function (Blueprint $table) {
            // Remover coluna genero se existir
            if (Schema::hasColumn('dependentes', 'genero')) {
                $table->dropColumn('genero');
            }
        });
    }
};
