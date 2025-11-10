<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
	public function up(): void
	{
		// 1) Remover qualquer FK antiga que possa existir
		try {
			Schema::table('historicos_pagamento', function (Blueprint $table) {
				// Por coluna
				$table->dropForeign(['id_servidor']);
			});
		} catch (\Throwable $e) {
			// ignora se já não existir
		}

		try {
			// Por nome conhecido (caso tenha sido criada manualmente antes)
			DB::statement('ALTER TABLE historicos_pagamento DROP FOREIGN KEY historicos_pagamento_id_servidor_foreign');
		} catch (\Throwable $e) {
			// ignora se já não existir
		}

		// 2) Garantir tipo compatível com servidores.id (bigint)
		Schema::table('historicos_pagamento', function (Blueprint $table) {
			$table->unsignedBigInteger('id_servidor')->change();
		});

		// 3) Recriar FK correta apontando para servidores.id
		Schema::table('historicos_pagamento', function (Blueprint $table) {
			$table->foreign('id_servidor')
				->references('id')
				->on('servidores')
				->onDelete('cascade');
		});
	}

	public function down(): void
	{
		// Remover a FK atual
		try {
			Schema::table('historicos_pagamento', function (Blueprint $table) {
				$table->dropForeign(['id_servidor']);
			});
		} catch (\Throwable $e) {
			// ignora
		}
	}
};


