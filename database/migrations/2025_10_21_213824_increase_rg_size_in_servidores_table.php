<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servidores', function (Blueprint $table) {
            // Aumentar o tamanho para 50 caracteres
            $table->string('rg', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('servidores', function (Blueprint $table) {
            // Reverter para o tamanho original se necessário
            $table->string('rg', 20)->nullable()->change();
        });
    }
};