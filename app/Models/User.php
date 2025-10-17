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

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    public function hasPermission($permission, $action = null)
    {
        $permissoes = $this->perfil->permissoes ?? [];
        
        if ($action) {
            return in_array($action, $permissoes[$permission] ?? []);
        }
        
        return $permissoes[$permission] ?? false;
    }

    // 🔴 **ALTERAÇÃO:** Método para encontrar usuário por CPF
    public function findForAuth($cpf)
    {
        return $this->where('cpf', $cpf)->first();
    }
}