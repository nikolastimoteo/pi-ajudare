@extends('layouts.app')

@section('assets')
  <link rel="stylesheet" href="{{ asset('template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
  <!-- Content Header -->
  <section class="content-header">
    <h1>
      {{ __('Campanhas') }}
      <small>Lista de Campanhas</small>
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
      <ol class="breadcrumb">
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
          <div class="box-header">
            <div class="row">
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="#" data-toggle="modal" data-target="#modal-cadastro-campanha" data-backdrop="static"
                  data-keyboard="false">
                  <div class="small-box bg-primary">
                    <div class="inner">
                      <h3>Nova</h3>

                      <p>Campanha</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-plus-circled"></i>
                    </div>
                  </div>
                </a>
              </div>
              <!-- ./col -->
            </div>
          </div>
          <div class="box-body">
            <table id="campanhas" class="table-bordered table-striped table">
              <thead>
                <tr>
                  <th>Título</th>
                  <th>Situação Prestações de Serviço</th>
                  <th>Situação Doações</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($campanhas as $campanha)
                  <tr>
                    <td>{{ $campanha->titulo }}</td>
                    <td>
                      @if ($campanha->aberta_prestacoes_servico)
                        ABERTA
                      @else
                        FECHADA
                      @endif
                    </td>
                    <td>
                      @if ($campanha->aberta_doacoes)
                        ABERTA
                      @else
                        FECHADA
                      @endif
                    </td>
                    <td>
                      <div class="btn-group">
                        <a href="{{ route('campanha.editar', $campanha->id) }}" class="btn btn-default btn-flat"><i
                            class="fa fa-edit"></i></a>
                        <button type="button" class="btn btn-default btn-flat button-excluir-campanha"
                          data-id="{{ $campanha->id }}" data-titulo="{{ $campanha->titulo }}" data-toggle="modal"
                          data-target="#modal-exclusao-campanha" data-backdrop="static" data-keyboard="false"><i
                            class="fa fa-trash"></i></button>
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

  <!-- Modal Cadastro Campanha -->
  <div class="modal fade" id="modal-cadastro-campanha" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cadastrar Campanha</h4>
        </div>
        <form id="form-cadastro-campanha">
          <div class="modal-body">
            <div class="form-group form-group-titulo has-feedback">
              <label for="titulo">Título</label>
              <input type="text" class="form-control" id="titulo" name="titulo"
                placeholder="Digite um título para a campanha">
              <span class="help-block" role="alert" id="erro-titulo"></span>
            </div>
            <div class="form-group form-group-descricao has-feedback">
              <label for="descricao">Descrição</label>
              <textarea class="form-control" rows="5" id="descricao" name="descricao"
                placeholder="Digite uma descrição para a campanha"></textarea>
              <span class="help-block" role="alert" id="erro-descricao"></span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /Modal Cadastro Campanha -->

  <!-- Modal Exclusão Campanha -->
  <div class="modal fade" id="modal-exclusao-campanha" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Excluir Campanha</h4>
        </div>
        <form method="POST" action="{{ route('campanha.excluir', ':campanha_id') }}">
          @method('DELETE')
          @csrf
          <div class="modal-body">
            <input type="hidden" id="campanha_id">
            <h4 id="titulo-campanha-exclusao"></h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Confirmar</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /Modal Exclusão Campanha -->
@endsection

@section('scripts')
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

      $('#campanhas').DataTable({
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

      // Ação botão excluir campanha
      $('#campanhas').on('click', '.button-excluir-campanha', function() {
        let action = $("#modal-exclusao-campanha form").attr('action');
        action = action.replace(':campanha_id', $(this).data('id'));

        $("#modal-exclusao-campanha form").attr('action', action);
        $('#campanha_id').val($(this).data('id'));
        $('#titulo-campanha-exclusao').text(
          `Deseja confirmar a exclusão da campanha "${$(this).data('titulo')}"?`);
      });

      // Evento fechar modal de exclusão de serviço
      $('#modal-exclusao-campanha').on('hidden.bs.modal', function() {
        $('#campanha_id').val('');
        $('#titulo-campanha-exclusao').text('');
        $("#modal-exclusao-campanha form").attr('action', '{{ route('campanha.excluir', ':campanha_id') }}');
      });

      $('#modal-cadastro-campanha').on('shown.bs.modal', function() {
        $('#titulo').focus();
      });

      $('#modal-cadastro-campanha').on('hidden.bs.modal', function() {
        $('#form-cadastro-campanha')[0].reset();
      });

      $('#form-cadastro-campanha').on('submit', function(e) {
        e.preventDefault();

        limparErrosFormularioCampanha();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          url: '{{ route('campanha.cadastrar') }}',
          data: $(this).serialize(),
          type: 'post',
          dataType: 'json',
          success: function(data) {
            let url = '{{ route('campanha.editar', ':id') }}';
            url = url.replace(':id', data.campanha.id);
            window.location = url;
          },
          error: function(data) {
            $.each(data.responseJSON.errors, function(key, value) {
              $('#erro-' + key).text(value);
              $('.form-group-' + key).addClass('has-error');
            });
          }
        });
      });

      function limparErrosFormularioCampanha() {
        $('#erro-titulo').text('');
        $('.form-group-titulo').removeClass('has-error');
        $('#erro-descricao').text('');
        $('.form-group-descricao').removeClass('has-error');
      }
    })
  </script>
@endsection
