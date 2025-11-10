<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ferias', function (Blueprint $table) {
            $table->id();
            $table->string('id_servidor'); // Matrícula do servidor (chave primária é string)
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->integer('dias');
            $table->string('status')->default('agendada'); // agendada, em_andamento, concluida
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            // Foreign key usando a matrícula como referência
            $table->foreign('id_servidor')->references('matricula')->on('servidores')->onDelete('cascade');
            
            // Índices para consultas por período
            $table->index(['data_inicio', 'data_fim']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ferias');
    }
};