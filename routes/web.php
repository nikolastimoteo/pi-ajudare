<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
})->name('welcome');

Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'autenticar'])->name('autenticar');
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('campanhas', [App\Http\Controllers\CampanhaController::class, 'index'])->name('campanha.index')->middleware('ong');
Route::post('campanhas', [App\Http\Controllers\CampanhaController::class, 'cadastrar'])->name('campanha.cadastrar');
Route::get('campanhas/{campanha_id}', [App\Http\Controllers\CampanhaController::class, 'editar'])->name('campanha.editar')->middleware('ong');
Route::put('campanhas/{campanha_id}', [App\Http\Controllers\CampanhaController::class, 'alterar'])->name('campanha.alterar');
Route::delete('campanhas/{campanha_id}', [App\Http\Controllers\CampanhaController::class, 'excluir'])->name('campanha.excluir');

Route::get('campanhas/{campanha_id}/servicos', [App\Http\Controllers\ServicoController::class, 'index'])->name('servico.index');
Route::post('campanhas/{campanha_id}/servicos', [App\Http\Controllers\ServicoController::class, 'cadastrar'])->name('servico.cadastrar');
Route::get('campanhas/{campanha_id}/servicos/{servico_id}', [App\Http\Controllers\ServicoController::class, 'editar'])->name('servico.editar');
Route::put('campanhas/{campanha_id}/servicos/{servico_id}', [App\Http\Controllers\ServicoController::class, 'alterar'])->name('servico.alterar');
Route::delete('campanhas/{campanha_id}/servicos/{servico_id}', [App\Http\Controllers\ServicoController::class, 'excluir'])->name('servico.excluir');

Route::get('campanhas/{campanha_id}/pedidos-doacao', [App\Http\Controllers\PedidoDoacaoController::class, 'index'])->name('pedido-doacao.index');
Route::post('campanhas/{campanha_id}/pedidos-doacao', [App\Http\Controllers\PedidoDoacaoController::class, 'cadastrar'])->name('pedido-doacao.cadastrar');
Route::get('campanhas/{campanha_id}/pedidos-doacao/{pedido_doacao_id}', [App\Http\Controllers\PedidoDoacaoController::class, 'editar'])->name('pedido-doacao.editar');
Route::put('campanhas/{campanha_id}/pedidos-doacao/{pedido_doacao_id}', [App\Http\Controllers\PedidoDoacaoController::class, 'alterar'])->name('pedido-doacao.alterar');
Route::delete('campanhas/{campanha_id}/pedidos-doacao/{pedido_doacao_id}', [App\Http\Controllers\PedidoDoacaoController::class, 'excluir'])->name('pedido-doacao.excluir');

Route::get('cidades/{sigla_estado}', [App\Http\Controllers\HelperController::class, 'obterCidadesPorEstadoParaSelect2'])->name('helper.cidadesSelect2');
Route::get('popular-dados-teste', [App\Http\Controllers\HelperController::class, 'popularDadosTeste'])->middleware('guest');
