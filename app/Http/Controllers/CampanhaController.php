<?php

namespace App\Http\Controllers;

use App\Models\Campanha;
use Illuminate\Http\Request;

class CampanhaController extends Controller
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
        $campanhas = Campanha::where('usuarios_id', auth()->user()->id)->get();

        return view('campanha.lista', compact('campanhas'));
    }

    public function cadastrar(Request $request)
    {
        $request->validate(
            [
                'titulo' => 'required|max:100',
                'descricao' => 'required|max:16777215'
            ],
            [
                'titulo.required' => 'Campo obrigatório.',
                'titulo.max' => 'Máximo 100 caracteres.',
                'descricao.required' => 'Campo obrigatorio.',
                'descricao.max' => 'Máximo 16777215 caracteres.',
            ]
        );

        $campanha = new Campanha();
        $campanha->titulo = $request->titulo;
        $campanha->descricao = $request->descricao;
        $campanha->usuarios_id = auth()->user()->id;
        $campanha->save();

        return response()->json(['success' => 'Campanha cadastrada com sucesso.', 'campanha' => $campanha]);
    }

    public function editar(int $campanha_id)
    {
        $campanha = Campanha::find($campanha_id);
        if ($campanha != null) {
            $estados = obterArraySiglaEstados();

            return view('campanha.edicao', compact('campanha', 'estados'));
        }

        return redirect()->back()->with('error', 'Campanha não encontrada.');
    }

    public function alterar(Request $request, int $campanha_id)
    {
        $request->validate(
            [
                'titulo' => 'required|max:100',
                'descricao' => 'required|max:16777215',
                'aberta_prestacoes_servico' => 'required',
                'aberta_doacoes' => 'required',
            ],
            [
                'titulo.required' => 'Campo obrigatório.',
                'titulo.max' => 'Máximo 100 caracteres.',
                'descricao.required' => 'Campo obrigatorio.',
                'descricao.max' => 'Máximo 16777215 caracteres.',
                'aberta_prestacoes_servico.required' => 'Campo obrigatorio.',
                'aberta_doacoes.required' => 'Campo obrigatorio.',
            ]
        );

        $campanha = Campanha::find($campanha_id);

        if ($campanha != null) {
            $campanha->titulo = $request->titulo;
            $campanha->descricao = $request->descricao;
            $campanha->aberta_prestacoes_servico = $request->aberta_prestacoes_servico;
            $campanha->aberta_doacoes = $request->aberta_doacoes;
            $campanha->save();

            return redirect()->back()->with('success', 'Campanha alterada com sucesso.');
        }

        return redirect()->back()->with('error', 'Campanha não encontrada.');
    }

    public function excluir(int $campanha_id)
    {
        $campanha = Campanha::find($campanha_id);
        if ($campanha != null) {
            $campanha->delete();

            return redirect()->back()->with('success', 'Campanha excluída com sucesso.');
        }

        return redirect()->back()->with('error', 'Campanha não encontrada.');
    }
}
