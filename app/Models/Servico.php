<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servico extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'servicos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'endereco',
        'cidade',
        'estado',
        'campanhas_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    public function prestacoesServico()
    {
        return $this->hasMany(PrestacaoServico::class, 'servicos_id');
    }

    public function campanha()
    {
        return $this->belongsTo(Campanha::class, 'campanhas_id');
    }
}
