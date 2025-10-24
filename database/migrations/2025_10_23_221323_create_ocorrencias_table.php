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
            $table->foreignId('id_servidor')->constrained('servidores')->onDelete('cascade');
            $table->string('tipo_ocorrencia');
            $table->text('descricao')->nullable();
            $table->date('data_ocorrencia');
            $table->string('status')->default('pendente'); // pendente, resolvida, etc.
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ocorrencias');
    }
};