<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidoDoacao extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pedidos_doacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'valor',
        'aceita_doacao_parcial',
        'campanhas_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    public function campanha()
    {
        return $this->belongsTo(Campanha::class, 'campanhas_id');
    }

    public function doacoes()
    {
        return $this->hasMany(Doacao::class, 'pedidos_doacao_id');
    }
}
