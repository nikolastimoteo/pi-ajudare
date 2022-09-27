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
      {{ __('Aplicações Pendentes') }}
      <small>Aplicações Pendentes</small>
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
                  <th>Voluntário</th>
                  <th>Ação</th>
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
                      </p>
                    </td>
                    <td>
                      {{ date('d/m/Y', strtotime($prestacaoServico->data_inicio)) }} à
                      {{ date('d/m/Y', strtotime($prestacaoServico->data_termino)) }}
                    </td>
                    <td>
                      {{ $prestacaoServico->voluntario->nome }}
                    </td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-flat button-responder-aplicacao"
                          data-id="{{ $prestacaoServico->id }}" data-servico="{{ $prestacaoServico->servico->titulo }}"
                          data-voluntario="{{ $prestacaoServico->voluntario->nome }}" data-resposta="aceita"
                          data-toggle="modal" data-target="#modal-responder-aplicacao" data-backdrop="static"
                          data-keyboard="false"><i class="fa fa-check" title="Aceitar"></i></button>
                        <button type="button" class="btn btn-default btn-flat button-responder-aplicacao"
                          data-id="{{ $prestacaoServico->id }}" data-servico="{{ $prestacaoServico->servico->titulo }}"
                          data-voluntario="{{ $prestacaoServico->voluntario->nome }}" data-resposta="recusada"
                          data-toggle="modal" data-target="#modal-responder-aplicacao" data-backdrop="static"
                          data-keyboard="false"><i class="fa fa-ban" title="Recusar"></i></button>
                      </div>
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
  <!-- Modal Responder Aplicação -->
  <div class="modal fade" id="modal-responder-aplicacao" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modal-title"></h4>
        </div>
        <form method="POST" action="{{ route('prestacao-servico.responder') }}">
          @method('PUT')
          @csrf
          <div class="modal-body">
            <input type="hidden" name="prestacoes_servico_id" id="prestacoes_servico_id">
            <input type="hidden" name="resposta" id="resposta">
            <h4 id="titulo-aplicacao"></h4>
            <div class="form-group form-group-observacao has-feedback">
              <label for="observacao">Observação</label>
              <textarea class="form-control" rows="5" id="observacao" name="observacao"
                placeholder="Digite informações necessárias ao voluntário" required></textarea>
              <span class="help-block" role="alert" id="erro-observacao"></span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Confirmar</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /Modal Responder Aplicação -->
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

      // Ação botão responder aplicação
      $('#aplicacoes').on('click', '.button-responder-aplicacao', function() {
        $('#prestacoes_servico_id').val($(this).data('id'));
        $('#resposta').val($(this).data('resposta'));
        if ($(this).data('resposta') === 'recusada') {
          $('#modal-title').text('Recusar Aplicação');
          $('#titulo-aplicacao').text(`Deseja recusar a aplicação do voluntário "${$(this).data('voluntario')}"
                ao serviço "${$(this).data('servico')}"?`);
        } else {
          $('#modal-title').text('Aceitar Aplicação');
          $('#titulo-aplicacao').text(`Deseja aceitar a aplicação do voluntário "${$(this).data('voluntario')}"
                ao serviço "${$(this).data('servico')}"?`);
        }
      });

      // Evento fechar modal de responder aplicação
      $('#modal-responder-aplicacao').on('hidden.bs.modal', function() {
        $('#prestacoes_servico_id').val('');
        $('#resposta').val('');
        $('#observacao').val('');
        $('#modal-title').text('');
        $('#titulo-aplicacao').text('');
      });

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
