<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoPagamento extends Model
{
    use HasFactory;

    protected $table = 'historicos_pagamento';

    protected $fillable = [
        'id_servidor',
        'mes_ano',
        'valor',
        'status',
        'data_pagamento',
        'observacoes'
    ];

    protected $casts = [
        'mes_ano' => 'date',
        'data_pagamento' => 'date',
        'valor' => 'decimal:2'
    ];

    public $timestamps = true;

    public function servidor()
    {
        return $this->belongsTo(Servidor::class, 'id_servidor');
    }
}