<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vinculo extends Model
{
    use HasFactory;

    protected $table = 'vinculos'; // ou o nome da sua tabela
    protected $primaryKey = 'idVinculo';

    protected $fillable = [
        'nomeVinculo',
        'descricao'
    ];

    public function servidores()
    {
        return $this->hasMany(Servidor::class, 'id_vinculo', 'idVinculo');
    }
}