<?php

namespace App\Http\Controllers;

use App\Models\Campanha;
use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
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
        $servicos = Servico::where('campanhas_id', $campanha_id)->get();

        return response()->json(['servicos' => $servicos]);
    }

    public function cadastrar(int $campanha_id, Request $request)
    {
        $request->validate(
            [
                'titulo' => 'required|max:100',
                'descricao' => 'required|max:16777215',
                'endereco' => 'required|max:100',
                'estado' => 'required',
                'cidade' => 'required',
            ],
            [
                'titulo.required' => 'Campo obrigatório.',
                'titulo.max' => 'Máximo 100 caracteres.',
                'descricao.required' => 'Campo obrigatorio.',
                'descricao.max' => 'Máximo 16777215 caracteres.',
                'endereco.required' => 'Campo obrigatorio.',
                'endereco.max' => 'Máximo 100 caracteres.',
                'estado.required' => 'Campo obrigatorio.',
                'cidade.required' => 'Campo obrigatorio.',
            ]
        );

        $servico = new Servico();
        $servico->titulo = $request->titulo;
        $servico->descricao = $request->descricao;
        $servico->endereco = $request->endereco;
        $servico->estado = $request->estado;
        $servico->cidade = $request->cidade;
        $servico->campanhas_id = $campanha_id;
        $servico->save();

        return response()->json(['success' => 'Serviço cadastrado com sucesso.']);
    }

    public function editar(int $campanha_id, int $servico_id)
    {
        $servico = Servico::where('id', $servico_id)->where('campanhas_id', $campanha_id)->first();

        return response()->json(['servico' => $servico]);
    }

    public function alterar(Request $request, int $campanha_id, int $servico_id)
    {
        $request->validate(
            [
                'titulo' => 'required|max:100',
                'descricao' => 'required|max:16777215',
                'endereco' => 'required|max:100',
                'estado' => 'required',
                'cidade' => 'required',
            ],
            [
                'titulo.required' => 'Campo obrigatório.',
                'titulo.max' => 'Máximo 100 caracteres.',
                'descricao.required' => 'Campo obrigatorio.',
                'descricao.max' => 'Máximo 16777215 caracteres.',
                'endereco.required' => 'Campo obrigatorio.',
                'endereco.max' => 'Máximo 100 caracteres.',
                'estado.required' => 'Campo obrigatorio.',
                'cidade.required' => 'Campo obrigatorio.',
            ]
        );

        $servico = Servico::where('id', $servico_id)->where('campanhas_id', $campanha_id)->first();

        if ($servico != null) {
            $servico->titulo = $request->titulo;
            $servico->descricao = $request->descricao;
            $servico->endereco = $request->endereco;
            $servico->estado = $request->estado;
            $servico->cidade = $request->cidade;
            $servico->save();

            return response()->json(['success' => 'Serviço alterado com sucesso.']);
        }

        return response()->json(['error' => 'Serviço não encontrado.'], 404);
    }

    public function excluir(int $campanha_id, int $servico_id)
    {
        $servico = Servico::where('id', $servico_id)->where('campanhas_id', $campanha_id)->first();
        $servico->delete();

        return response()->json(['success' => 'Serviço excluído com sucesso.']);
    }
}
