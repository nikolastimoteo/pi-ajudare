<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'senha',
        'nome',
        'endereco',
        'cidade',
        'estado',
        'biografia',
        'cpf',
        'data_nascimento',
        'cnpj',
        'voluntario',
        'ong',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function prestacoesServico()
    {
        return $this->hasMany(PrestacaoServico::class, 'usuarios_id');
    }

    public function campanhas()
    {
        return $this->hasMany(Campanha::class, 'usuarios_id');
    }

    public function doacoes()
    {
        return $this->hasMany(Doacao::class, 'usuarios_id');
    }

    public function isONG()
    {
        return $this->ong;
    }

    public function isVoluntario()
    {
        return $this->voluntario;
    }
}
