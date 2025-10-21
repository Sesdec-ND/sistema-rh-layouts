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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // 🔴 **MUTATOR para padronizar CPF**
    public function setCpfAttribute($value)
    {
        // Remove qualquer formatação existente
        $cpf = preg_replace('/[^0-9]/', '', $value);
        
        // Aplica a formatação padrão: 000.000.000-00
        if (strlen($cpf) === 11) {
            $this->attributes['cpf'] = substr($cpf, 0, 3) . '.' . 
                                     substr($cpf, 3, 3) . '.' . 
                                     substr($cpf, 6, 3) . '-' . 
                                     substr($cpf, 9, 2);
        } else {
            $this->attributes['cpf'] = $value;
        }
    }

    // 🔴 **ACCESSOR para garantir exibição consistente**
    public function getCpfAttribute($value)
    {
        return $value; // Já estará formatado pelo mutator
    }

    public function dependentes()
    {
        return $this->hasMany(Dependente::class);
    }
    
    public function user()
    {
        return $this->hasOne(User::class, 'cpf', 'cpf');
    }
}