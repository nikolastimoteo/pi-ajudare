<?php

namespace App\Http\Controllers;

use App\Models\PedidoDoacao;
use Illuminate\Http\Request;

class PedidoDoacaoController extends Controller
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

    public function index(int $campanha_id)
    {
        $pedidos = PedidoDoacao::where('campanhas_id', $campanha_id)->get();

        return response()->json(['pedidos' => $pedidos]);
    }

    public function cadastrar(int $campanha_id, Request $request)
    {
        $request->validate(
            [
                'titulo' => 'required|max:100',
                'descricao' => 'required|max:16777215',
                'valor' => 'required|numeric|min:1',
                'aceita_doacao_parcial' => 'required',
            ],
            [
                'titulo.required' => 'Campo obrigatório.',
                'titulo.max' => 'Máximo 100 caracteres.',
                'descricao.required' => 'Campo obrigatorio.',
                'descricao.max' => 'Máximo 16777215 caracteres.',
                'valor.required' => 'Campo obrigatorio.',
                'valor.numeric' => 'Campo numérico.',
                'valor.min' => 'Mínimo R$ 1,00.',
                'aceita_doacao_parcial.required' => 'Campo obrigatorio.',
            ]
        );

        $pedido = new PedidoDoacao();
        $pedido->titulo = $request->titulo;
        $pedido->descricao = $request->descricao;
        $pedido->valor = $request->valor;
        $pedido->aceita_doacao_parcial = $request->aceita_doacao_parcial;
        $pedido->campanhas_id = $campanha_id;
        $pedido->save();

        return response()->json(['success' => 'Pedido de Doação cadastrado com sucesso.']);
    }

    public function editar(int $campanha_id, int $pedido_doacao_id)
    {
        $pedido = PedidoDoacao::where('id', $pedido_doacao_id)->where('campanhas_id', $campanha_id)->first();

        return response()->json(['pedido' => $pedido]);
    }

    public function alterar(Request $request, int $campanha_id, int $pedido_doacao_id)
    {
        $request->validate(
            [
                'titulo' => 'required|max:100',
                'descricao' => 'required|max:16777215',
                'valor' => 'required|numeric|min:1',
                'aceita_doacao_parcial' => 'required',
            ],
            [
                'titulo.required' => 'Campo obrigatório.',
                'titulo.max' => 'Máximo 100 caracteres.',
                'descricao.required' => 'Campo obrigatorio.',
                'descricao.max' => 'Máximo 16777215 caracteres.',
                'valor.required' => 'Campo obrigatorio.',
                'valor.numeric' => 'Campo numérico.',
                'valor.min' => 'Mínimo R$ 1,00.',
                'aceita_doacao_parcial.required' => 'Campo obrigatorio.',
            ]
        );

        $pedido = PedidoDoacao::where('id', $pedido_doacao_id)->where('campanhas_id', $campanha_id)->first();

        if ($pedido != null) {
            $pedido->titulo = $request->titulo;
            $pedido->descricao = $request->descricao;
            $pedido->valor = $request->valor;
            $pedido->aceita_doacao_parcial = $request->aceita_doacao_parcial;
            $pedido->save();

            return response()->json(['success' => 'Pedido de Doação alterado com sucesso.']);
        }

        return response()->json(['error' => 'Pedido de Doação não encontrado.'], 404);
    }

    public function excluir(int $campanha_id, int $pedido_doacao_id)
    {
        $pedido = PedidoDoacao::where('id', $pedido_doacao_id)->where('campanhas_id', $campanha_id)->first();
        $pedido->delete();

        return response()->json(['success' => 'Pedido de Doação excluído com sucesso.']);
    }
}
