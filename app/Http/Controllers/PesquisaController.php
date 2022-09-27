<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class PesquisaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $estados = obterArraySiglaEstados();

        return view('pesquisa.index', compact('estados'));
    }

    public function pesquisar(Request $request)
    {
        $params = [];

        if ($request->estado != '')
            array_push($params, ['estado', '=', $request->estado]);
        if ($request->cidade != '')
            array_push($params, ['cidade', '=', $request->cidade]);
        if ($request->titulo != '')
            array_push($params, ['titulo', 'like', '%' . $request->titulo . '%']);

        $servicos = Servico::where($params)
            ->whereHas('campanha', function ($query) {
                return $query->where('aberta_prestacoes_servico', true);
            })
            ->whereDoesntHave('prestacoesServico', function ($query) {
                return $query->where('usuarios_id', auth()->user()->id);
            })
            ->get();

        $resultados = $servicos->map(function ($servico) {
            return [
                'id' => $servico->id,
                'titulo' => $servico->titulo,
                'descricao' => $servico->descricao,
                'endereco' => $servico->endereco,
                'isServico' => true,
                'ong' => $servico->campanha->ong->nome,
                'tituloCampanha' => $servico->campanha->titulo,
                'cidade' => $servico->cidade . ' - ' . $servico->estado,
            ];
        });

        return response()->json(['resultados' => $resultados]);
    }
}
