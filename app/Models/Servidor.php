<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula',
        'foto',
        'nome_completo',
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
    protected $table = 'servidores';

    // Relacionamentos
    public function vinculo()
    {
        return $this->belongsTo(Vinculo::class, 'id_vinculo');
    }

    public function lotacao()
    {
        return $this->belongsTo(Lotacao::class, 'id_lotacao');
    }

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
}