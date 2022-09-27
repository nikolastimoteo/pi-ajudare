<?php

namespace App\Http\Controllers;

use App\Models\PrestacaoServico;
use Illuminate\Http\Request;

class PrestacaoServicoController extends Controller
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

    public function index()
    {
        if (auth()->user()->isONG()) {
            $prestacoesServico = PrestacaoServico::whereHas('servico.campanha', function ($query) {
                return $query->where('usuarios_id', auth()->user()->id);
            })
                ->whereNull('data_aceite')
                ->whereNull('data_recusa')
                ->whereNull('data_cancelamento')
                ->get();
            return view('aplicacoes.lista', compact('prestacoesServico'));
        } else {
            $prestacoesServico = PrestacaoServico::where('usuarios_id', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
            return view('aplicacoes.minha-lista', compact('prestacoesServico'));
        }

        return view('aplicacoes.lista', compact('prestacoesServico'));
    }

    public function cadastrar(Request $request)
    {
        $request->validate(
            [
                'data_inicio' => 'required|date',
                'data_termino' => 'required|date|after_or_equal:data_inicio',
            ],
            [
                'data_inicio.required' => 'Campo obrigatório.',
                'data_inicio.date' => 'Digite uma data válida.',
                'data_termino.required' => 'Campo obrigatório.',
                'data_termino.date' => 'Digite uma data válida.',
                'data_termino.after_or_equal' => 'A data de término deve ser maior ou igual a data de início.',
            ]
        );

        $prestacaoServico = PrestacaoServico::where('servicos_id', $request->servicos_id)
            ->where('usuarios_id', auth()->user()->id)
            ->first();

        if ($prestacaoServico != null) {
            return response()->json(['error' => 'Aplicação já efetuada para este serviço.'], 422);
        }

        $prestacaoServico = new PrestacaoServico();
        $prestacaoServico->data_inicio = $request->data_inicio;
        $prestacaoServico->data_termino = $request->data_termino;
        $prestacaoServico->servicos_id = $request->servicos_id;
        $prestacaoServico->usuarios_id = auth()->user()->id;
        $prestacaoServico->save();

        return response()->json(['success' => 'Aplicação cadastrada com sucesso.']);
    }

    public function responder(Request $request)
    {
        $prestacaoServico = PrestacaoServico::find($request->prestacoes_servico_id);

        if ($prestacaoServico != null) {
            if ($request->resposta == 'aceita') {
                $prestacaoServico->data_aceite = date('Y-m-d');
                $prestacaoServico->observacao = $request->observacao;
            } else {
                $prestacaoServico->data_recusa = date('Y-m-d');
                $prestacaoServico->motivo_recusa = $request->observacao;
            }
            $prestacaoServico->save();

            return redirect()->back()->with('success', 'Aplicação respondida com sucesso.');
        }

        return redirect()->back()->with('error', 'Aplicação não encontrada.');
    }
}
