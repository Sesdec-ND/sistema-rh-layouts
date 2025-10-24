<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    use HasFactory;

    protected $table = 'ocorrencias';

    protected $fillable = [
        'id_servidor',
        'tipo_ocorrencia',
        'descricao',
        'data_ocorrencia',
        'status',
        'observacoes'
    ];

    protected $casts = [
        'data_ocorrencia' => 'date',
    ];

    public function servidor()
    {
        return $this->belongsTo(Servidor::class, 'id_servidor');
    }
}