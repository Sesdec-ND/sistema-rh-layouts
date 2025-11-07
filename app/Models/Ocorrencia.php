<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ocorrencia extends Model
{
    use HasFactory;

    protected $table = 'ocorrencias';

    protected $fillable = [
        'id_servidor',
        'tipo_ocorrencia',
        'descricao',
        'data_ocorrencia',
        'status',
    ];

    public $timestamps = true;

    protected $casts = [
        'data_ocorrencia' => 'date',
    ];

    public function servidor()
    {
        return $this->belongsTo(Servidor::class, 'id_servidor');
    }
}