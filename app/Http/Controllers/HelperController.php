<?php

namespace App\Http\Controllers;

use App\Models\PedidoDoacao;
use App\Models\Servico;
use App\Models\Campanha;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HelperController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('popularDadosTeste');
    }

    public function obterCidadesPorEstadoParaSelect2($sigla_estado)
    {
        $cidades = obterArrayNomesCidadesPorEstado($sigla_estado);
        $arrayFormatado = array_map('mapSelect2', $cidades, $cidades);

        return response()->json($arrayFormatado);
    }

    public function popularDadosTeste()
    {
        $pedidosDoacao = PedidoDoacao::all()->pluck('id')->toArray();
        PedidoDoacao::destroy($pedidosDoacao);

        $servicos = Servico::all()->pluck('id')->toArray();
        Servico::destroy($servicos);

        $campanhas = Campanha::all()->pluck('id')->toArray();
        Campanha::destroy($campanhas);

        $usuario = Usuario::where('email', 'teste@ong.com')->first();
        if (!$usuario) {
            $usuario = new Usuario();
            $usuario->email = 'teste@ong.com';
            $usuario->senha = Hash::make('testeong');
            $usuario->nome = 'ONG Teste';
            $usuario->cnpj = '69494192000136';
            $usuario->voluntario = 0;
            $usuario->ong = 1;
            $usuario->save();
        }

        $usuario = Usuario::where('email', 'teste@voluntario.com')->first();
        if (!$usuario) {
            $usuario = new Usuario();
            $usuario->email = 'teste@voluntario.com';
            $usuario->senha = Hash::make('testevoluntario');
            $usuario->nome = 'Voluntário Teste';
            $usuario->cpf = '09732801077';
            $usuario->data_nascimento = '1992-08-25';
            $usuario->voluntario = 1;
            $usuario->ong = 0;
            $usuario->save();
        }

        return redirect('login');
    }
}
