<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ferias extends Model
{
    use HasFactory;

    protected $table = 'ferias';

    protected $fillable = [
        'id_servidor',
        'data_inicio',
        'data_fim',
        'dias',
        'status',
        'observacoes'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date'
    ];

    public function servidor()
    {
        return $this->belongsTo(Servidor::class, 'id_servidor');
    }
}