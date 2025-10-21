<?php
// app/Models/Servidor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servidor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'matricula',
        'nome_completo',
        'cpf',
        'rg',
        'data_nascimento',
        'genero',
        'estado_civil',
        'telefone',
        'endereco',
        'raca_cor',
        'tipo_sanguineo',
        'foto',
        'formacao',
        'pis_pasep',
        'data_nomeacao',
        'id_vinculo',
        'id_lotacao'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'data_nomeacao' => 'date',
    ];

    public function dependentes()
    {
        return $this->hasMany(Dependente::class);
    }
    
    public function user()
    {
        return $this->hasOne(User::class, 'cpf', 'cpf');
    }
}