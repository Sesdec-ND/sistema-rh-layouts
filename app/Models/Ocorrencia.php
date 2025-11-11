<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    use HasFactory;

    protected $table = 'ocorrencias';

    protected $fillable = [
        'tipo_ocorrencia',
        'data_ocorrencia',
        'descricao',
        'status',
        'observacoes',
        'id_servidor',
    ];

    protected $casts = [
        'data_ocorrencia' => 'date',
    ];

    // Relacionamentos
    public function servidor()
    {
        return $this->belongsTo(Servidor::class, 'id_servidor', 'id');
    }
}