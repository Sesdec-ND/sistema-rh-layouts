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

    protected $table = 'servidores'; // ← Especificar a tabela
    protected $primaryKey = 'id';
    public $timestamps = true;

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
