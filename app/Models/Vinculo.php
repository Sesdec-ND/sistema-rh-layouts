<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vinculo extends Model
{
    use HasFactory;

    protected $table = 'vinculos';

    protected $fillable = [
        'nomeVinculo',
        'descricao',
    ];

    // Se a chave primária for diferente
    protected $primaryKey = 'idVinculo';

    // Se não usar timestamps
    public $timestamps = true;

    // Accessor para nome (para compatibilidade)
    public function getNomeAttribute()
    {
        return $this->nomeVinculo;
    }

    protected $casts = [
        'status' => 'boolean'
    ];

    public function servidores()
    {
        return $this->hasMany(Servidor::class, 'vinculo_id');
    }
}