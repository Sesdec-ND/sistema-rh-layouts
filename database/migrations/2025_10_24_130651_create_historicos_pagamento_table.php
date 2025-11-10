<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historicos_pagamento', function (Blueprint $table) {
            $table->id();
            $table->string('id_servidor'); // Matrícula do servidor (chave primária é string)
            $table->date('mes_ano');
            $table->decimal('valor', 10, 2);
            $table->string('status')->default('pendente'); // pendente, pago, atrasado
            $table->date('data_pagamento')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            // Foreign key usando a matrícula como referência
            $table->foreign('id_servidor')->references('matricula')->on('servidores')->onDelete('cascade');
            
            // Índice para melhor performance em consultas por mês/ano
            $table->index(['mes_ano', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('historicos_pagamento');
    }
};