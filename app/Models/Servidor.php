<?php
// app/Models/Servidor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

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

    // Adicione um atributo para garantir arrays vazios
    protected $attributes = [
    'foto' => '[]',
    'deleted_at' => '[]'
    ];

    // Relacionamento com dependentes
    public function dependentes()
    {
        return $this->hasMany(Dependente::class);
    }

    // Acessor para idade
    public function getIdadeAttribute()
    {
        return $this->data_nascimento ? Carbon::parse($this->data_nascimento)->age : null;
    }

    // Acessor para tempo de serviço
    public function getTempoServicoAttribute()
    {
        return $this->data_nomeacao ? Carbon::parse($this->data_nomeacao)->diffInYears(now()) : null;
    }

    // Acessor para URL da foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/avatar-default.png');
    }

    // Scope para servidores ativos
    public function scopeAtivos($query)
    {
        return $query->whereNull('deleted_at');
    }

    // Scope por lotação
    public function scopePorLotacao($query, $lotacao)
    {
        return $query->where('id_lotacao', $lotacao);
    }

    // Scope por vínculo
    public function scopePorVinculo($query, $vinculo)
    {
        return $query->where('id_vinculo', $vinculo);
    }

    // Relacionamento com User (se existir)
    public function user()
    {
        return $this->hasOne(User::class, 'cpf', 'cpf');
    }

    // Método para verificar se está próximo da aposentadoria (exemplo)
    //public function verificarProximidadeAposentadoria()
    // {
        // $idade = $this->idade;
        // $tempoServico = $this->tempo_servico;

        // Lógica simplificada para aposentadoria
        // if ($idade >= 65 || $tempoServico >= 35) {
           // return 'Elegível para aposentadoria';
        // } elseif ($idade >= 60 || $tempoServico >= 30) {
          //  return 'Próximo da aposentadoria';
        //}

        //return 'Não elegível no momento';
    //}
}
