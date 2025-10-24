<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_servidor')->constrained('servidores')->onDelete('cascade');
            $table->string('nome');
            $table->string('instituicao');
            $table->integer('carga_horaria');
            $table->date('data_conclusao');
            $table->string('tipo')->nullable(); // presencial, online, hibrido
            $table->string('certificado')->nullable(); // caminho do arquivo do certificado
            $table->text('descricao')->nullable();
            $table->timestamps();
            
            // Índice para consultas por data e carga horária
            $table->index(['data_conclusao', 'carga_horaria']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cursos');
    }
};