<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('servidores', function (Blueprint $table) {
            // Lista de campos que devem existir baseado no Model
            $campos = [
                'rg' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'rg')) {
                        $table->string('rg')->nullable()->after('cpf');
                    }
                },
                'data_nascimento' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'data_nascimento')) {
                        $table->date('data_nascimento')->nullable()->after('rg');
                    }
                },
                'genero' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'genero')) {
                        $table->enum('genero', ['Masculino', 'Feminino'])->nullable()->after('data_nascimento');
                    }
                },
                'estado_civil' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'estado_civil')) {
                        $table->enum('estado_civil', ['Solteiro(a)', 'Casado(a)', 'Divorciado(a)', 'Viúvo(a)'])->nullable()->after('genero');
                    }
                },
                'telefone' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'telefone')) {
                        $table->string('telefone')->nullable()->after('estado_civil');
                    }
                },
                'endereco' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'endereco')) {
                        $table->text('endereco')->nullable()->after('telefone');
                    }
                },
                'raca_cor' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'raca_cor')) {
                        $table->enum('raca_cor', ['Branca', 'Preta', 'Parda', 'Amarela'])->nullable()->after('endereco');
                    }
                },
                'tipo_sanguineo' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'tipo_sanguineo')) {
                        $table->enum('tipo_sanguineo', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable()->after('raca_cor');
                    }
                },
                'foto' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'foto')) {
                        $table->string('foto')->nullable()->after('tipo_sanguineo');
                    }
                },
                'formacao' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'formacao')) {
                        $table->string('formacao')->nullable()->after('foto');
                    }
                },
                'pis_pasep' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'pis_pasep')) {
                        $table->string('pis_pasep')->nullable()->after('formacao');
                    }
                },
                'data_nomeacao' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'data_nomeacao')) {
                        $table->date('data_nomeacao')->nullable()->after('pis_pasep');
                    }
                },
                'id_vinculo' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'id_vinculo')) {
                        $table->enum('id_vinculo', ['Efetivo', 'Comissionado', 'Voluntário', 'PVSA'])->nullable()->after('data_nomeacao');
                    }
                },
                'id_lotacao' => function () use ($table) {
                    if (!Schema::hasColumn('servidores', 'id_lotacao')) {
                        $table->enum('id_lotacao', ['PM', 'PC', 'Politec', 'Bombeiros'])->nullable()->after('id_vinculo');
                    }
                }
            ];

            // Executar apenas os campos que não existem
            foreach ($campos as $campo => $callback) {
                $callback();
            }
        });
    }

    public function down()
    {
        Schema::table('servidores', function (Blueprint $table) {
            // Remover APENAS as colunas que existem
            $columnsToDrop = [];

            $possibleColumns = [
                'rg',
                'data_nascimento',
                'genero',
                'estado_civil',
                'telefone',
                'endereco',
                'raca_cor',
                'tipo_sanguineo',
                'foto',
                'formacao',
                'pispasep',
                'data_nomeacao',
                'id_vinculo',
                'id_lotacao'
            ];

            foreach ($possibleColumns as $column) {
                if (Schema::hasColumn('servidores', $column)) {
                    $columnsToDrop[] = $column;
                }
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
