<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('lotacoes', function (Blueprint $table) {
        $table->bigIncrements('id_lotacao');
        $table->string('nome_lotacao');
        $table->string('sigla')->nullable();
        $table->string('departamento')->nullable();
        $table->string('localizacao')->nullable();
        $table->boolean('status')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotacoes');
    }
};
