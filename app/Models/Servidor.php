<?php
// app/Models/Servidor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servidor extends Model
{
    use HasFactory, SoftDeletes;

    // ESPECIFIQUE O NOME CORRETO DA TABELA
    protected $table = 'servidores';

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
        'formacao',
        'pis_pasep',
        'data_nomeacao',
        'id_vinculo',
        'id_lotacao',
        'foto'
    ];

    


    protected $casts, $dates = [
        'data_nascimento' => 'date',
        'data_nomeacao' => 'date',
        'deleted_at' => 'date'
    ];

    public function dependentes()
    {
        return $this->hasMany(Dependente::class);
    }
}