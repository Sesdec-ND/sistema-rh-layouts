<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formacao extends Model
{
    use HasFactory;

    protected $table = 'formacoes';

    protected $fillable = [
        'id_servidor',
        'curso',
        'instituicao',
        'nivel',
        'ano_conclusao',
        'duracao',
        'descricao'
    ];

    public function servidor()
    {
        return $this->belongsTo(Servidor::class, 'id_servidor');
    }
}