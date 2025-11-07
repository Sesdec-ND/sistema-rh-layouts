<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'id_servidor',
        'nome',
        'instituicao',
        'carga_horaria',
        'data_conclusao',
        'certificado'
    ];

    public $timestamps = true;

    // protected $casts = [
        // 'data_conclusao' => 'date'
    // ];

    public function servidor()
    {
        return $this->belongsTo(Servidor::class, 'id_servidor');
    }
}