<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('servidores', function (Blueprint $table) {
            $table->id();
            $table->string('matricula')->unique();
            $table->string('nome_completo');
            $table->string('cpf', 14)->unique();
            $table->string('rg', 20);
            $table->date('data_nascimento');
            $table->string('genero');
            $table->string('estado_civil');
            $table->string('telefone');
            $table->text('endereco');
            $table->string('raca_cor');
            $table->string('tipo_sanguineo');
            $table->string('formacao')->nullable();
            $table->string('pis_pasep')->nullable();
            $table->date('data_nomeacao')->nullable();
            $table->string('id_vinculo')->nullable();
            $table->string('id_lotacao')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servidores');
    }
};