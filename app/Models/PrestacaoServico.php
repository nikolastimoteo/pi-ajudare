<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrestacaoServico extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prestacoes_servico';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'data_inicio',
        'data_termino',
        'data_aceite',
        'observacao',
        'data_recusa',
        'motivo_recusa',
        'data_cancelamento',
        'motivo_cancelamento',
        'cancelada_pela_ong',
        'cancelada_pelo_voluntario',
        'servicos_id',
        'usuarios_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    public function avaliacaoServico()
    {
        return $this->hasOne(AvaliacaoServico::class, 'prestacoes_servico_id');
    }

    public function avaliacaoServicoPrestado()
    {
        return $this->hasOne(AvaliacaoServicoPrestado::class, 'prestacoes_servico_id');
    }

    public function voluntario()
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id');
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class, 'servicos_id');
    }
}
