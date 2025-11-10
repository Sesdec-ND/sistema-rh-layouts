<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ocorrencias', function (Blueprint $table) {
            $table->id();
            $table->string('id_servidor'); // Matrícula do servidor (chave primária é string)
            $table->string('tipo_ocorrencia');
            $table->text('descricao')->nullable();
            $table->date('data_ocorrencia');
            $table->string('status')->default('pendente'); // pendente, resolvida, etc.
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            // Foreign key usando a matrícula como referência
            $table->foreign('id_servidor')->references('matricula')->on('servidores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ocorrencias');
    }
};