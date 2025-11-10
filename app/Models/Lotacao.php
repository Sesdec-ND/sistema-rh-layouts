<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotacao extends Model
{
    use HasFactory;

    protected $table = 'lotacoes';

	protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nome_lotacao',
        'sigla',
        'departamento',
        'localizacao',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Relacionamentos
    public function servidores()
    {
		return $this->hasMany(Servidor::class, 'id_lotacao', 'id');
    }

    // Scopes
    public function scopeAtivas($query)
    {
        return $query->where('status', true);
    }

    // Accessors
    public function getNomeCompletoAttribute()
    {
        return "{$this->sigla} - {$this->nome_lotacao}";
    }
}