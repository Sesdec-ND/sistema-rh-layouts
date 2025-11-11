<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoPagamento extends Model
{
    use HasFactory;

    protected $table = 'historicos_pagamento';

    protected $fillable = [
        'mes_ano',
        'valor',
        'status',
        'data_pagamento',
        'observacoes',
        'id_servidor',
    ];

    protected $casts = [
        'mes_ano' => 'date',
        'valor' => 'decimal:2',
        'data_pagamento' => 'date',
    ];

    // Relacionamentos
    public function servidor()
    {
<<<<<<< HEAD
		return $this->belongsTo(Servidor::class, 'id_servidor', 'id');
=======
        return $this->belongsTo(Servidor::class, 'id_servidor', 'id');
>>>>>>> 0abed94 (mostrando servidor por id e config de pdf)
    }

    // Accessors
    public function getCompetenciaAttribute()
    {
        return $this->mes_ano ? $this->mes_ano->format('m/Y') : null;
    }

    public function getValorFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor, 2, ',', '.');
    }
}