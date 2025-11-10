<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\User;

class Servidor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servidores';

    protected $primaryKey = 'matricula';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nome_completo',
        'email',
        'matricula',
        'cpf',
        'rg',
        'data_nascimento',
        'genero',
        'estado_civil',
        'formacao',
        'status',
        'data_nomeacao',
        'telefone',
        'endereco',
        'raca_cor',
        'tipo_sanguineo',
        'pispasep',
        'id_vinculo',
        'id_lotacao',
        'foto',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'data_nomeacao' => 'date',
        'status' => 'boolean',
    ];

    protected $dates = [
        'data_nascimento',
        'data_nomeacao',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Relacionamentos
    public function vinculo()
    {
        return $this->belongsTo(Vinculo::class, 'id_vinculo', 'id_vinculo');
    }

    public function lotacao()
    {
        return $this->belongsTo(Lotacao::class, 'id_lotacao', 'id_lotacao');
    }

    public function dependentes()
    {
        return $this->hasMany(Dependente::class, 'id_servidor', 'matricula');
    }

    public function ocorrencias()
    {
        return $this->hasMany(Ocorrencia::class, 'id_servidor', 'matricula');
    }

    public function historicoPagamentos()
    {
        return $this->hasMany(HistoricoPagamento::class, 'id_servidor', 'matricula');
    }

    public function ferias()
    {
        return $this->hasMany(Ferias::class, 'id_servidor', 'matricula');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'cpf', 'cpf');
    }

    // Métodos de cálculo (conforme UML)
    public function calcularIdade()
    {
        return Carbon::parse($this->data_nascimento)->age;
    }

    public function verificarProximidadeAposentadoria()
    {
        // Exemplo: considerar aposentadoria aos 65 anos
        $idadeAposentadoria = 65;
        $idadeAtual = $this->calcularIdade();
        $anosRestantes = $idadeAposentadoria - $idadeAtual;
        
        return [
            'idade_atual' => $idadeAtual,
            'anos_restantes' => $anosRestantes,
            'proximo_aposentadoria' => $anosRestantes <= 5
        ];
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('status', true);
    }

    public function scopeInativos($query)
    {
        return $query->where('status', false);
    }

    // Accessors
    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : asset('images/default-avatar.png');
    }

    public function getFormattedCpfAttribute()
    {
        $cpf = $this->cpf;
        if (strlen($cpf) === 11) {
            return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        }
        return $cpf;
    }

    public function getFormattedTelefoneAttribute()
    {
        $telefone = preg_replace('/\D/', '', $this->telefone);
        
        if (strlen($telefone) === 11) {
            return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 5) . '-' . substr($telefone, 7, 4);
        } elseif (strlen($telefone) === 10) {
            return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 4) . '-' . substr($telefone, 6, 4);
        }
        
        return $this->telefone;
    }

    // Mutators
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/\D/', '', $value);
    }

    public function setTelefoneAttribute($value)
    {
        $this->attributes['telefone'] = preg_replace('/\D/', '', $value);
    }

    public function setNomeCompletoAttribute($value)
    {
        $this->attributes['nome_completo'] = ucwords(strtolower($value));
    }
}