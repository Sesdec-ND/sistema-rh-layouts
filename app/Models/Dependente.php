<?php
// app/Models/Dependente.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependente extends Model
{
    use HasFactory;

    protected $fillable = [
        'servidor_id',
        'nome',
        'idade',
        'data_nascimento',
        'cpf'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function servidor()
    {
        return $this->belongsTo(Servidor::class);
    }
}