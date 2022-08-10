<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campanha extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'campanhas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'aberta_prestacoes_servico',
        'aberta_doacoes',
        'usuarios_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    public function servicos()
    {
        return $this->hasMany(Servico::class, 'campanhas_id');
    }

    public function pedidosDoacao()
    {
        return $this->hasMany(PedidoDoacao::class, 'campanhas_id');
    }

    public function parceiros()
    {
        return $this->hasMany(Parceiro::class, 'campanhas_id');
    }

    public function ong()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id');
    }
}
