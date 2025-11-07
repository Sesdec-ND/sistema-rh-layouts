<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependente extends Model
{
    use HasFactory;

    protected $table = 'dependentes';

    protected $fillable = [
        'id_servidor',
        'nome',
        'parentesco',
        'data_nascimento',
        'cpf'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public $timestamps = true;

    public function servidor()
    {
        return $this->belongsTo(Servidor::class, 'id_servidor');
    }
}