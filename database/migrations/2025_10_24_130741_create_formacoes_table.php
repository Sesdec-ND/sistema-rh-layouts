<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('formacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_servidor')->constrained('servidores')->onDelete('cascade');
            $table->string('curso');
            $table->string('instituicao');
            $table->string('nivel'); // graduacao, pos_graduacao, mestrado, doutorado, tecnico
            $table->integer('ano_conclusao');
            $table->string('duracao')->nullable();
            $table->text('descricao')->nullable();
            $table->timestamps();
            
            // Índice para consultas por nível de formação
            $table->index(['nivel', 'ano_conclusao']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('formacoes');
    }
};