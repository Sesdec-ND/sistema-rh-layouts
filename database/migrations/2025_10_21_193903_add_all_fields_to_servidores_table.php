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
        Schema::table('servidores', function (Blueprint $table) {
            // Adicionando colunas que já podem existir (nullable para evitar erros)
            if (!Schema::hasColumn('servidores', 'rg')) {
                $table->string('rg', 20)->nullable()->after('cpf');
            }
            if (!Schema::hasColumn('servidores', 'data_nascimento')) {
                $table->date('data_nascimento')->nullable()->after('rg');
            }

            // Adicionando todas as outras colunas que provavelmente estão faltando
            if (!Schema::hasColumn('servidores', 'foto')) {
                $table->string('foto')->nullable()->after('matricula');
            }
            if (!Schema::hasColumn('servidores', 'genero')) {
                $table->string('genero', 20)->nullable()->after('data_nascimento');
            }
            if (!Schema::hasColumn('servidores', 'estado_civil')) {
                $table->string('estado_civil', 20)->nullable()->after('genero');
            }
            if (!Schema::hasColumn('servidores', 'telefone')) {
                $table->string('telefone', 20)->nullable()->after('estado_civil');
            }
            if (!Schema::hasColumn('servidores', 'endereco')) {
                $table->string('endereco')->nullable()->after('telefone');
            }
            if (!Schema::hasColumn('servidores', 'formacao')) {
                $table->string('formacao')->nullable()->after('endereco');
            }
            if (!Schema::hasColumn('servidores', 'status')) {
                $table->boolean('status')->default(true)->after('formacao');
            }
            if (!Schema::hasColumn('servidores', 'raca_cor')) {
                $table->string('raca_cor', 50)->nullable()->after('status');
            }
            if (!Schema::hasColumn('servidores', 'tipo_sanguineo')) {
                $table->string('tipo_sanguineo', 5)->nullable()->after('raca_cor');
            }
            if (!Schema::hasColumn('servidores', 'pispasep')) {
                $table->string('pispasep', 20)->nullable()->after('tipo_sanguineo');
            }
            if (!Schema::hasColumn('servidores', 'data_nomeacao')) {
                $table->date('data_nomeacao')->nullable()->after('pispasep');
            }
            if (!Schema::hasColumn('servidores', 'id_vinculo')) {
                $table->unsignedBigInteger('id_vinculo')->nullable()->after('data_nomeacao');
                // Se você tem uma tabela 'vinculos', descomente a linha abaixo
                // $table->foreign('id_vinculo')->references('id_vinculo')->on('vinculos')->onDelete('set null');
            }
            if (!Schema::hasColumn('servidores', 'id_lotacao')) {
                $table->unsignedBigInteger('id_lotacao')->nullable()->after('id_vinculo');
                // Se você tem uma tabela 'lotacoes', descomente a linha abaixo
                // $table->foreign('id_lotacao')->references('id_lotacao')->on('lotacoes')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servidores', function (Blueprint $table) {
            // Opcional: Adicionar a lógica para remover as colunas se precisar reverter
            $table->dropColumn(['rg', 'data_nascimento', 'foto', 'genero', 'estado_civil', 'telefone', 'endereco', 'formacao', 'status', 'raca_cor', 'tipo_sanguineo', 'pispasep', 'data_nomeacao', 'id_vinculo', 'id_lotacao']);
        });
    }
};
