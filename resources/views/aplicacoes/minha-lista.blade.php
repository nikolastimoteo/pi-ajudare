@extends('layouts.app')

@section('assets')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Datepicker -->
  <link rel="stylesheet"
    href="{{ asset('template/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
  <!-- Content Header -->
  <section class="content-header">
    <h1>
      {{ __('Minhas Aplicações') }}
      <small>Minhas Aplicações de Serviços</small>
    </h1>
    @if (Session::has('success'))
      <ol class="breadcrumb mensagem-status">
        <li>
          <div class="alert alert-success alert-dismissible alert-resizing">
            <i class="icon fa fa-check"></i> {!! Session::get('success') !!}
          </div>
        </li>
      </ol>
    @endif
    @if (Session::has('error'))
      <ol class="breadcrumb mensagem-status">
        <li>
          <div class="alert alert-danger alert-dismissible alert-resizing">
            <i class="icon fa fa-ban"></i> {!! Session::get('error') !!}
          </div>
        </li>
      </ol>
    @endif
  </section>

  <!-- Main content -->
  <section class="content container-fluid">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            <table id="aplicacoes" class="table-bordered table-striped table">
              <thead>
                <tr>
                  <th>Serviço</th>
                  <th>Período</th>
                  <th>Situação</th>
                  <th>Observação</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($prestacoesServico as $prestacaoServico)
                  <tr>
                    <td>
                      <p><strong>Serviço: {{ $prestacaoServico->servico->titulo }}</strong><br>
                        {{ $prestacaoServico->servico->descricao }}<br>
                        Campanha: {{ $prestacaoServico->servico->campanha->titulo }}<br>
                        Endereço: {{ $prestacaoServico->servico->endereco }}<br>
                        Cidade: {{ $prestacaoServico->servico->cidade }} -
                        {{ $prestacaoServico->servico->estado }}<br>
                        ONG: {{ $prestacaoServico->servico->campanha->ong->nome }}
                      </p>
                    </td>
                    <td>
                      {{ date('d/m/Y', strtotime($prestacaoServico->data_inicio)) }} à
                      {{ date('d/m/Y', strtotime($prestacaoServico->data_termino)) }}
                    </td>
                    <td>
                      @if ($prestacaoServico->data_aceite != null)
                        ACEITA
                      @elseif ($prestacaoServico->data_recusa != null)
                        RECUSADA
                      @elseif ($prestacaoServico->data_cancelamento != null)
                        RECUSADA
                      @else
                        PENDENTE
                      @endif
                    </td>
                    <td>
                      @if ($prestacaoServico->data_aceite != null)
                        {{ $prestacaoServico->observacao }}
                      @elseif ($prestacaoServico->data_recusa != null)
                        {{ $prestacaoServico->motivo_recusa }}
                      @elseif ($prestacaoServico->data_cancelamento != null)
                        {{ $prestacaoServico->motivo_cancelamento }}
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
@endsection

@section('scripts')
  <!-- DataTables -->
  <script src="{{ asset('template/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
  <script type="text/javascript">
    $(function() {
      /**
       *
       * GERAIS
       *
       */
      setInterval(function() {
        $('.mensagem-status').remove();
      }, 10000);


      $('#aplicacoes').DataTable({
        language: {
          decimal: ",",
          processing: "Processando...",
          search: "Pesquisar:",
          lengthMenu: "_MENU_ registros por página",
          info: "Mostrando de _START_ até _END_ de _TOTAL_ registro(s)",
          infoEmpty: "Mostrando 0 até 0 de 0 registro(s)",
          infoFiltered: "(Filtrados de _MAX_ registro(s))",
          infoPostFix: "",
          loadingRecords: "Carregando...",
          zeroRecords: "Nenhum registro encontrado",
          emptyTable: "Nenhum registro encontrado",
          paginate: {
            first: "Primeiro",
            previous: "Anterior",
            next: "Próximo",
            last: "Último"
          },
          aria: {
            sortAscending: ": Ordenar colunas de forma ascendente",
            sortDescending: ": Ordenar colunas de forma descendente"
          },
        },
        pageLength: 25
      });
    })
  </script>
@endsection
