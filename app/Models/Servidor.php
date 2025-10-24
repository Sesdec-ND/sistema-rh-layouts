<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Carbon\Carbon;
=======
use App\Models\Ocorrencia;
>>>>>>> 63240714e901e04b4112207e53b8967f9bee30ee

class Servidor extends Model
{
    use HasFactory;

    protected $table = 'servidores';

    protected $fillable = [
        'matricula',
        'foto',
        'nome_completo',
        'email',
        'cpf',
        'rg',
        'data_nascimento',
        'genero',
        'estado_civil',
        'telefone',
        'endereco',
        'formacao',
        'status',
        'tracador',
        'tipo_sanguineo',
        'pispasep',
        'data_nomeacao',
        'id_vinculo',
        'id_lotacao'
    ];
    

    // Adicionar casts para datas
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
 
    // Relacionamentos
    public function vinculo()
    {
        return $this->belongsTo(Vinculo::class, 'id_vinculo', 'idVinculo');
    }

    public function lotacao()
    {
        return $this->belongsTo(Lotacao::class, 'id_lotacao', 'idLotacao');
    }

     // Accessor para nome (para compatibilidade)
    public function getNomeAttribute()
    {
        return $this->nome_completo;
    }
    
    // Accessor para status (baseado na data de nomeação)
    public function getStatusAttribute()
    {
        // Considera ativo se tem data de nomeação e não foi deletado
        return !empty($this->data_nomeacao) && empty($this->deleted_at);
    }
    
    // Accessor para lotacao_id (para compatibilidade)
    public function getLotacaoIdAttribute()
    {
        return $this->idLotacao;
    }
    
    // Accessor para vinculo_id (para compatibilidade)
    public function getVinculoIdAttribute()
    {
        return $this->idVinculo;
    }

    // Adicione um atributo para garantir arrays vazios
    protected $attributes = [
    'foto' => '[]',
    'deleted_at' => '[]'
    ];

    // Relacionamento com dependentes
    public function dependentes()
    {
        return $this->hasMany(Dependente::class, 'id_servidor');
    }

    public function ocorrencias()
    {
        return $this->hasMany(Ocorrencia::class, 'id_servidor');
    }

    public function historicosPagamento()
    {
        return $this->hasMany(HistoricoPagamento::class, 'id_servidor');
    }

    public function ferias()
    {
        return $this->hasMany(Ferias::class, 'id_servidor');
    }

    public function formacoes()
    {
        return $this->hasMany(Formacao::class, 'id_servidor');
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id_servidor');
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
        return $query->where('idLotacao', $lotacao);
    }

    // Scope por vínculo
    public function scopePorVinculo($query, $vinculo)
    {
        return $query->where('idVinculo', $vinculo);
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
