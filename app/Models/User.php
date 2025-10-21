<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\Perfil;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'rg',
        'username',
        'perfil_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissoes' => 'array'
        ];
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

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'perfil_id');
    }

    /**
     * Relacionamento com Servidor
     */
    public function servidor()
    {
        return $this->belongsTo(Servidor::class, 'cpf', 'cpf');
        // Ou se tiver uma coluna servidor_id:
        // return $this->belongsTo(Servidor::class, 'servidor_id');
    }

    public function hasPermission($modulo, $acao = null)
    {
        if (!$this->perfil || !$this->perfil->permissoes) {
            return false;
        }

        // ⭐⭐ CORREÇÃO: Use diretamente o array (já convertido pelo cast do Perfil)
        $permissoes = $this->perfil->permissoes;
        
        // Se o módulo não existe nas permissões
        if (!isset($permissoes[$modulo])) {
            return false;
        }

        $permissaoModulo = $permissoes[$modulo];

        // Se for booleano (true/false)
        if (is_bool($permissaoModulo)) {
            return $permissaoModulo;
        }

        // Se for array de permissões específicas
        if (is_array($permissaoModulo)) {
            // Se não especificou ação, verifica se tem alguma permissão
            if ($acao === null) {
                return !empty($permissaoModulo);
            }
            
            // Verifica se a ação específica está no array
            return in_array($acao, $permissaoModulo);
        }

        return false;
    }

    // 🔴 **ALTERAÇÃO:** Método para encontrar usuário por CPF
    public function findForAuth($cpf)
    {
        // Remove formatação para busca
        $cpfBusca = preg_replace('/[^0-9]/', '', $cpf);
        return $this->whereRaw("REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), ' ', '') = ?", [$cpfBusca])->first();
    }
}