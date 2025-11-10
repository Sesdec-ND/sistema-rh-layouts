<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dependentes', function (Blueprint $table) {
            $table->id();
            $table->string('id_servidor'); // Matrícula do servidor (chave primária é string)
            $table->string('nome');
            $table->string('parentesco');
            $table->date('data_nascimento');
            $table->string('cpf')->nullable();
            $table->string('genero')->nullable();
            $table->timestamps();
            
            // Foreign key usando a matrícula como referência
            $table->foreign('id_servidor')->references('matricula')->on('servidores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dependentes');
    }
};