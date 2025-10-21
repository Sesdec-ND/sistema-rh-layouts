<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotacao extends Model
{
    use HasFactory;

    protected $table = 'lotacoes'; // ou o nome da sua tabela
    protected $primaryKey = 'idLotacao';

    protected $fillable = [
        'nomeLotacao',
        'sigla',
        'departamento',
        'localizacao',
        'status'
    ];

    public function servidores()
    {
        return $this->hasMany(Servidor::class, 'id_lotacao', 'idLotacao');
    }
}