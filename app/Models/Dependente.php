<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Dependente extends Model
{
    use HasFactory;

    protected $table = 'dependentes';

    protected $fillable = [
        'id_servidor',
        'nome',
        'parentesco',
        'data_nascimento',
        'cpf',
        'genero',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    // Relacionamentos
    public function servidor()
    {
        return $this->belongsTo(Servidor::class, 'id_servidor', 'id');
    }

    // Métodos
    public function calcularIdade()
    {
        return $this->data_nascimento ? Carbon::parse($this->data_nascimento)->age : null;
    }

    // Accessors
    public function getFormattedCpfAttribute()
    {
        $cpf = $this->cpf;
        if ($cpf && strlen($cpf) === 11) {
            return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        }
        return $cpf;
    }
}