<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotacao extends Model
{
    use HasFactory;

    protected $table = 'lotacoes';

    protected $fillable = [
        'nomeLotacao',
        'sigla',
        'departamento',
        'localizacao',
        'status'
    ];

    // Se a chave primária for diferente
    protected $primaryKey = 'idLotacao';

    // Se não usar timestamps
    public $timestamps = true;

    // Accessor para nome (para compatibilidade)
    public function getNomeAttribute()
    {
        return $this->nomeLotacao;
    }

    protected $casts = [
        'status' => 'boolean'
    ];

    public function servidores()
    {
        return $this->hasMany(Servidor::class, 'lotacao_id');
    }
}