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
            $table->string('nome_completo');
            $table->string('email')->unique();
            $table->string('matricula')->unique();
            $table->string('cpf', 14)->unique();
            $table->string('rg', 6)->nullable();
            $table->string('formacao')->nullable();
            $table->string('telefone')->nullable();
            $table->string('id_vinculo')->nullable();
            $table->string('id_lotacao')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('servidores', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
    
};