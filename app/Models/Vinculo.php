<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vinculo extends Model
{
    use HasFactory;

    protected $table = 'vinculos';

	protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nome_vinculo',
        'descricao',
    ];

    // Relacionamentos
    public function servidores()
    {
		return $this->hasMany(Servidor::class, 'id_vinculo', 'id');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->whereHas('servidores', function($q) {
            $q->where('status', true);
        });
    }
}