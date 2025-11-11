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

    // Usando id como chave primária padrão do Laravel
    // protected $primaryKey = 'id';
    // public $incrementing = true;
    // protected $keyType = 'int';

<<<<<<< HEAD
=======
    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

>>>>>>> 0abed94 (mostrando servidor por id e config de pdf)
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
        return $this->belongsTo(Vinculo::class, 'id_vinculo', 'id');
    }

    public function lotacao()
    {
        return $this->belongsTo(Lotacao::class, 'id_lotacao', 'id');
    }

    public function dependentes()
    {
        return $this->hasMany(Dependente::class, 'id_servidor', 'id');
    }

    public function ocorrencias()
    {
        return $this->hasMany(Ocorrencia::class, 'id_servidor', 'id');
    }

    public function historicoPagamentos()
    {
        return $this->hasMany(HistoricoPagamento::class, 'id_servidor', 'id');
    }

    public function ferias()
    {
        return $this->hasMany(Ferias::class, 'id_servidor', 'id');
    }

<<<<<<< HEAD
    // 🔴 RELACIONAMENTO CORRIGIDO - Busca flexível por CPF
=======
    public function formacoes()
    {
        return $this->hasMany(Formacao::class, 'id_servidor', 'id');
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id_servidor', 'id');
    }

>>>>>>> 0abed94 (mostrando servidor por id e config de pdf)
    public function user()
    {
        // Busca o usuário comparando CPF sem formatação
        return $this->hasOne(User::class, 'cpf', 'cpf')
            ->orWhereRaw("REPLACE(REPLACE(REPLACE(users.cpf, '.', ''), '-', ''), ' ', '') = REPLACE(REPLACE(REPLACE(?, '.', ''), '-', ''), ' ', '')", [$this->cpf]);
    }

    // 🔴 MÉTODO AUXILIAR - Retorna o usuário de forma confiável
    public function getUserAttribute()
    {
        $cpfLimpo = preg_replace('/[^0-9]/', '', $this->cpf);
        return User::whereRaw("REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), ' ', '') = ?", [$cpfLimpo])->first();
    }

    // Métodos de cálculo (conforme UML)
    public function calcularIdade()
    {
        return Carbon::parse($this->data_nascimento)->age;
    }

    public function verificarProximidadeAposentadoria()
    {
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
        // Remove qualquer formatação existente
        $cpf = preg_replace('/[^0-9]/', '', $value);
        
        // Aplica a formatação padrão: 000.000.000-00
        if (strlen($cpf) === 11) {
            $this->attributes['cpf'] = substr($cpf, 0, 3) . '.' . 
                                     substr($cpf, 3, 3) . '.' . 
                                     substr($cpf, 6, 3) . '-' . 
                                     substr($cpf, 9, 2);
        } else {
            // Se não tiver 11 dígitos, salva como veio
            $this->attributes['cpf'] = $value;
        }
    }

    // Accessor para CPF (garante exibição consistente)
    public function getCpfAttribute($value)
    {
        return $value; // Já estará formatado pelo mutator
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