<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doacao extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doacoes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'valor_doado',
        'data_doacao',
        'codigo_pix',
        'data_expiracao_codigo_pix',
        'data_confirmacao_pagamento',
        'usuarios_id',
        'pedidos_doacao_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    public function pedidoDoacao()
    {
        return $this->belongsTo(PedidoDoacao::class, 'pedidos_doacao_id');
    }

    public function voluntario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id');
    }
}
