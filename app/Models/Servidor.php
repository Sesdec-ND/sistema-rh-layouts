<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ocorrencia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servidor extends Model
{
    use HasFactory, SoftDeletes;

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
        'status' => 'boolean',
    ];
     
    // 🔥 MUTATOR para estado_civil - garante valor correto
    public function setEstadoCivilAttribute($value)
    {
        // Mapeia valores do formulário para valores do ENUM
        $map = [
            'Solteiro' => 'Solteiro(a)',
            'Casado' => 'Casado(a)', 
            'Divorciado' => 'Divorciado(a)',
            'Viúvo' => 'Viúvo(a)'
        ];
        
        $this->attributes['estado_civil'] = $map[$value] ?? $value;
    }

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
        return $this->belongsTo(Vinculo::class, 'id_vinculo');
    }

    public function lotacao()
    {
        return $this->belongsTo(Lotacao::class, 'id_lotacao');
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
        'status' => true,
        'foto' => null
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
}
