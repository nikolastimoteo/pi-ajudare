@extends('layouts.app')

@section('assets')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- iCheck 1.0.1 -->
  <link rel="stylesheet" href="{{ asset('template/plugins/iCheck/all.css') }}">
@endsection

@section('content')
  <!-- Content Header -->
  <section class="content-header">
    <h1>
      {{ __('Campanhas') }}
      <small>Editar Campanha</small>
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
      <!-- Dados -->
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Dados</h3>
          </div>
          <form method="POST" action="{{ route('campanha.alterar', $campanha->id) }}">
            @method('PUT')
            @csrf
            <div class="box-body">
              <input type="hidden" id="campanha_id" name="id" value="{{ $campanha->id }}">
              <div class="form-group form-group-titulo has-feedback @error('titulo') has-error @enderror">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo-campanha" name="titulo"
                  value="{{ old('titulo', $campanha->titulo) }}" placeholder="Digite um título para a campanha">
                @error('titulo')
                  <span class="help-block" role="alert">
                    {{ $message }}
                  </span>
                @enderror
              </div>
              <div class="form-group form-group-descricao has-feedback @error('descricao') has-error @enderror">
                <label for="descricao">Descrição</label>
                <textarea class="form-control" rows="5" id="descricao-campanha" name="descricao"
                  placeholder="Digite uma descrição para a campanha">{{ old('descricao', $campanha->descricao) }}</textarea>
                @error('descricao')
                  <span class="help-block" role="alert">
                    {{ $message }}
                  </span>
                @enderror
              </div>
              <div class="form-group form-group-aberta-prestacoes-servico has-feedback">
                <label for="aberta-prestacoes-servico">Aberta para prestação de serviços?</label><br>
                <label>
                  <input type="radio" class="form-control minimal" id="aberta-prestacoes-servico-s"
                    {{ old('aberta_prestacoes_servico', $campanha->aberta_prestacoes_servico) == '1' ? 'checked' : '' }}
                    name="aberta_prestacoes_servico" value="1">
                  Sim
                </label>
                <label class="margin-left-checkbox-radio">
                  <input type="radio" class="form-control minimal" id="aberta-prestacoes-servico-n"
                    {{ old('aberta_prestacoes_servico', $campanha->aberta_prestacoes_servico) == '0' ? 'checked' : '' }}
                    name="aberta_prestacoes_servico" value="0">
                  Não
                </label>
              </div>
              <div class="form-group form-group-aberta-doacoes has-feedback">
                <label for="aberta-prestacoes-servico">Aberta para doação?</label><br>
                <label>
                  <input type="radio" class="form-control minimal" id="aberta-doacoes-s"
                    {{ old('aberta_doacoes', $campanha->aberta_doacoes) == '1' ? 'checked' : '' }} name="aberta_doacoes"
                    value="1">
                  Sim
                </label>
                <label class="margin-left-checkbox-radio">
                  <input type="radio" class="form-control minimal" id="aberta-doacoes-n"
                    {{ old('aberta_doacoes', $campanha->aberta_doacoes) == '0' ? 'checked' : '' }} name="aberta_doacoes"
                    value="0">
                  Não
                </label>
              </div>
            </div>
            <div class="box-footer">
              <a href="{{ route('campanha.index') }}" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</a>
              <button type="submit" class="btn btn-primary pull-right">Salvar</button>
            </div>
          </form>
        </div>
      </div>
      <!-- /Dados -->
    </div>

    <div class="row">
      <!-- Serviços -->
      <div class="col-md-6 col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Serviços</h3>
            <button type="button" class="btn btn-success pull-right" data-toggle="modal"
              data-target="#modal-cadastro-servico" data-backdrop="static" data-keyboard="false">
              Novo Serviço
            </button>
          </div>
          <div class="box-body">
            <div id="mensagem-status-servico">
              <!-- mensagem de status serviço -->
            </div>
            <table id="servicos" class="table-bordered table-striped table">

            </table>
          </div>
        </div>
      </div>
      <!-- /Serviços -->

      <!-- Pedidos de Doação -->
      <div class="col-md-6 col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Pedidos de Doação</h3>
            <button type="button" class="btn btn-success pull-right" data-toggle="modal"
              data-target="#modal-cadastro-pedido" data-backdrop="static" data-keyboard="false">
              Novo Pedido
            </button>
          </div>
          <div class="box-body">
            <div id="mensagem-status-pedido">
              <!-- mensagem de status serviço -->
            </div>
            <table id="pedidos" class="table-bordered table-striped table">

            </table>
          </div>
        </div>
      </div>
      <!-- /Pedidos de Doação -->
    </div>
  </section>
  <!-- /.content -->

  <!-- Modal Cadastro Serviço -->
  <div class="modal fade" id="modal-cadastro-servico" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cadastrar Serviço</h4>
        </div>
        <form id="form-cadastro-servico">
          <div class="modal-body">
            <input type="hidden" id="servico_id" name="id">
            <div class="form-group form-group-titulo has-feedback">
              <label for="titulo">Título</label>
              <input type="text" class="form-control" id="titulo" name="titulo"
                placeholder="Digite um título para o serviço">
              <span class="help-block" role="alert" id="erro-titulo"></span>
            </div>
            <div class="form-group form-group-descricao has-feedback">
              <label for="descricao">Descrição</label>
              <textarea class="form-control" rows="5" id="descricao" name="descricao"
                placeholder="Digite uma descrição para o serviço"></textarea>
              <span class="help-block" role="alert" id="erro-descricao"></span>
            </div>
            <div class="form-group form-group-endereco has-feedback">
              <label for="endereco">Endereço</label>
              <input type="text" class="form-control" id="endereco" name="endereco"
                placeholder="Digite o endereço de execução do serviço">
              <span class="help-block" role="alert" id="erro-endereco"></span>
            </div>
            <div class="form-group form-group-estado has-feedback">
              <label for="estado">Estado</label>
              <select name="estado" id="estado" class="form-control select2 estado" style="width: 100%;">
                <option value="">Selecione um estado</option>
                @foreach ($estados as $estado)
                  <option value="{{ $estado }}">{{ $estado }}</option>
                @endforeach
              </select>
              <span class="help-block" role="alert" id="erro-estado"></span>
            </div>
            <div class="form-group form-group-cidade has-feedback">
              <label for="cidade">Cidade</label>
              <select name="cidade" id="cidade" class="form-control select2 cidade" style="width: 100%;" disabled>
                <option value="">Selecione um estado para desbloquear</option>
              </select>
              <span class="help-block" role="alert" id="erro-cidade"></span>
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
  <!-- /Modal Cadastro Serviço -->

  <!-- Modal Exclusão Serviço -->
  <div class="modal fade" id="modal-exclusao-servico" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Excluir Serviço</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id-servico-exclusao">
          <h4 id="titulo-servico-exclusao"></h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button type="button" id="confirmar-servico-exclusao" class="btn btn-danger">Confirmar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /Modal Exclusão Serviço -->

  <!-- Modal Cadastro Pedido de Doação -->
  <div class="modal fade" id="modal-cadastro-pedido" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cadastrar Pedido de Doação</h4>
        </div>
        <form id="form-cadastro-pedido">
          <div class="modal-body">
            <input type="hidden" id="pedido_doacao_id" name="id">
            <div class="form-group form-group-titulo has-feedback">
              <label for="titulo">Título</label>
              <input type="text" class="form-control" id="titulo" name="titulo"
                placeholder="Digite um título para o serviço">
              <span class="help-block" role="alert" id="erro-titulo"></span>
            </div>
            <div class="form-group form-group-descricao has-feedback">
              <label for="descricao">Descrição</label>
              <textarea class="form-control" rows="5" id="descricao" name="descricao"
                placeholder="Digite uma descrição para o serviço"></textarea>
              <span class="help-block" role="alert" id="erro-descricao"></span>
            </div>

            <div class="form-group form-group-valor has-feedback">
              <label for="valor">Valor (R$)</label>
              <input type="number" class="form-control" id="valor" name="valor">
              <span class="help-block" role="alert" id="erro-valor"></span>
            </div>
            <div class="form-group form-group-aceita-doacao-parcial has-feedback">
              <label for="aceita-doacao-parcial">Aceita doação parcial?</label><br>
              <label>
                <input type="radio" class="form-control minimal" id="aceita-doacao-parcial-s" checked
                  name="aceita_doacao_parcial" value="1">
                Sim
              </label>
              <label class="margin-left-checkbox-radio">
                <input type="radio" class="form-control minimal" id="aceita-doacao-parcial-n"
                  name="aceita_doacao_parcial" value="0">
                Não
              </label>
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
  <!-- /Modal Cadastro Pedido de Doação -->

  <!-- Modal Exclusão Pedido de Doação -->
  <div class="modal fade" id="modal-exclusao-pedido" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Excluir Pedido de Doação</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id-pedido-exclusao">
          <h4 id="titulo-pedido-exclusao"></h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button type="button" id="confirmar-pedido-exclusao" class="btn btn-danger">Confirmar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /Modal Exclusão Pedido de Doação -->
@endsection

@section('scripts')
  <!-- DataTables -->
  <script src="{{ asset('template/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
  <!-- iCheck 1.0.1 -->
  <script src="{{ asset('template/plugins/iCheck/icheck.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('template/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <script type="text/javascript">
    $(function() {
      /**
       *
       * VARIAVEIS GLOBAIS
       *
       */
      let cidadeSelecionadaEdicao = '';

      /**
       *
       * GERAIS
       *
       */
      setInterval(function() {
        $('.mensagem-status').remove();
      }, 10000);

      $('input[type="radio"].minimal').iCheck({
        radioClass: 'iradio_minimal-blue'
      });

      $('.select2').select2();

      loadDataTableServicos();
      loadDataTablePedidos();

      /**
       *
       * SERVIÇO
       *
       */
      // Ação botão editar serviço
      $('#servicos').on('click', '.button-editar-servico', function() {
        loadModalServicoSelecionado($(this).data('id'));
      });

      // Ação botão excluir serviço
      $('#servicos').on('click', '.button-excluir-servico', function() {
        $('#id-servico-exclusao').val($(this).data('id'));
        $('#titulo-servico-exclusao').text(`Deseja confirmar a exclusão do serviço "${$(this).data('titulo')}"?`);
      });

      // Ação botão confirmar da modal de exclusão de serviço
      $('#confirmar-servico-exclusao').on('click', function() {
        excluirServico($('#id-servico-exclusao').val());
      });

      // Evento fechar modal de exclusão de serviço
      $('#modal-exclusao-servico').on('hidden.bs.modal', function() {
        $('#id-servico-exclusao').val('');
        $('#titulo-servico-exclusao').text('');
      });

      // Evento change dos Select2 de Estado
      $('#modal-cadastro-servico .estado').change(function() {
        $('#modal-cadastro-servico .select2.cidade').empty().trigger('change');
        $('#modal-cadastro-servico .select2.cidade').select2({
          data: [{
            id: '',
            text: 'Selecione um estado para desbloquear'
          }]
        });
        $('#modal-cadastro-servico .select2.cidade').prop('disabled', true);

        if ($(this).val() !== '') {
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          let ajaxUrl = '{{ route('helper.cidadesSelect2', ':estado') }}';
          ajaxUrl = ajaxUrl.replace(':estado', $(this).val());

          $.ajax({
            url: ajaxUrl,
            type: 'get',
            dataType: 'json',
            success: function(data) {
              if (Array.isArray(data) && data.length > 0) {
                $('#modal-cadastro-servico .select2.cidade').empty().trigger('change');
                $('#modal-cadastro-servico .select2.cidade').select2({
                  data: [{
                    id: '',
                    text: 'Selecione uma cidade'
                  }]
                });
                $('#modal-cadastro-servico .select2.cidade').select2({
                  data: data
                })
                $('#modal-cadastro-servico .select2.cidade').prop('disabled', false);

                // caso edição, cidadeSelecionadaEdicao estará preenchido
                if (cidadeSelecionadaEdicao !== '') {
                  $('#modal-cadastro-servico .select2.cidade').val(cidadeSelecionadaEdicao)
                    .trigger('change');
                  cidadeSelecionadaEdicao = '';
                }
              }
            }
          });
        }
      });

      // Evento abrir modal de cadastro de serviço
      $('#modal-cadastro-servico').on('shown.bs.modal', function() {
        $('#modal-cadastro-servico #titulo').focus();
      });

      // Evento fechar modal de cadastro de serviço
      $('#modal-cadastro-servico').on('hidden.bs.modal', function() {
        limpaCamposFormularioServico();
        $('#modal-cadastro-servico .modal-title').text('Cadastrar Serviço');
        cidadeSelecionadaEdicao = '';
        limparErrosFormularioServico();
      });

      // Envia o formulário de serviço cadastro/alteração
      $('#form-cadastro-servico').on('submit', function(e) {
        e.preventDefault();

        limparErrosFormularioServico();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        let id = $('#servico_id').val();
        let url = '{{ route('servico.cadastrar', $campanha->id) }}';
        let type = 'post';
        if (id !== '') {
          url = '{{ route('servico.alterar', [':campanha_id', ':servico_id']) }}';
          url = url.replace(':campanha_id', $('#campanha_id').val()).replace(':servico_id', id);
          type = 'put';
        }

        $.ajax({
          url: url,
          data: $(this).serialize(),
          type: type,
          dataType: 'json',
          success: function(data) {
            if (data.success) {
              loadDataTableServicos(true);
              mostraMensagemStatusServico(data.success);
              $('#modal-cadastro-servico').modal('hide');
            }
          },
          error: function(data) {
            if (data.responseJSON.errors) {
              $.each(data.responseJSON.errors, function(key, value) {
                $('#modal-cadastro-servico #erro-' + key).text(value);
                $('#modal-cadastro-servico .form-group-' + key).addClass('has-error');
              });
            }

            if (data.responseJSON.error) {
              loadDataTableServicos(true);
              mostraMensagemStatusServico(data.responseJSON.error, true);
              $('#modal-cadastro-servico').modal('hide');
            }
          }
        });
      });

      // Limpa os campos do formulário de serviço
      function limpaCamposFormularioServico() {
        $('#form-cadastro-servico')[0].reset();
        $('#servico_id').val('');
        $('#modal-cadastro-servico .select2.estado').val('');
        $('#modal-cadastro-servico .select2.estado').trigger('change');
        $('#modal-cadastro-servico .modal-title').text('Cadastrar Serviço');
      }

      // Limpa os erros do formulário de serviço
      function limparErrosFormularioServico() {
        $('#modal-cadastro-servico #erro-titulo').text('');
        $('#modal-cadastro-servico .form-group-titulo').removeClass('has-error');
        $('#modal-cadastro-servico #erro-descricao').text('');
        $('#modal-cadastro-servico .form-group-descricao').removeClass('has-error');
        $('#modal-cadastro-servico #erro-endereco').text('');
        $('#modal-cadastro-servico .form-group-endereco').removeClass('has-error');
        $('#modal-cadastro-servico #erro-estado').text('');
        $('#modal-cadastro-servico .form-group-estado').removeClass('has-error');
        $('#modal-cadastro-servico #erro-cidade').text('');
        $('#modal-cadastro-servico .form-group-cidade').removeClass('has-error');
      }

      // Busca os dados para a tabela de serviços
      function loadDataTableServicos(reload = false) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          url: '{{ route('servico.index', $campanha->id) }}',
          type: 'get',
          dataType: 'json',
          success: function(data) {
            if (data.servicos) {
              renderDataTableServicos(data.servicos, reload);
            }
          }
        });
      }

      // Atualiza a tabela de serviços
      function renderDataTableServicos(servicos, reload) {
        let data = servicos.map(function(servico) {
          return {
            'titulo': servico.titulo,
            'endereco': `${servico.endereco}, ${servico.cidade} - ${servico.estado}`,
            'acoes': `<div class="btn-group">
                        <button type="button" class="btn btn-default btn-flat button-editar-servico" data-id="${servico.id}"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-default btn-flat button-excluir-servico" data-id="${servico.id}" data-titulo="${servico.titulo}"
                            data-toggle="modal" data-target="#modal-exclusao-servico" data-backdrop="static" data-keyboard="false"><i class="fa fa-trash"></i></button>
                      </div>`,
          }
        });

        // primera vez
        if (!reload) {
          $('#servicos').DataTable({
            data: data,
            columns: [{
                title: 'Título',
                data: 'titulo'
              },
              {
                title: 'Endereço',
                data: 'endereco'
              },
              {
                title: 'Ações',
                data: 'acoes'
              },
            ],
            ordering: false,
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
            pageLength: 10
          });
          return;
        }

        $('#servicos').DataTable().clear().rows.add(data).draw();
      }

      // Busca os dados do serviço selecionado para alteração
      function loadModalServicoSelecionado(id) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        let url = '{{ route('servico.editar', [':campanha_id', ':servico_id']) }}';
        url = url.replace(':campanha_id', $('#campanha_id').val()).replace(':servico_id', id);

        $.ajax({
          url: url,
          type: 'get',
          dataType: 'json',
          success: function(data) {
            if (data.servico) {
              renderModalServico(data.servico);
            }
          }
        });
      }

      // Atualiza o formulário de serviço para edição
      function renderModalServico(servico) {
        $('#modal-cadastro-servico .modal-title').text('Editar Serviço');
        $('#modal-cadastro-servico #servico_id').val(servico.id);
        $('#modal-cadastro-servico #titulo').val(servico.titulo);
        $('#modal-cadastro-servico #descricao').val(servico.descricao);
        $('#modal-cadastro-servico #endereco').val(servico.endereco);
        cidadeSelecionadaEdicao = servico.cidade;
        $('#modal-cadastro-servico .select2.estado').val(servico.estado).trigger('change');

        $('#modal-cadastro-servico').modal('show');
      }

      // Mostra a mensagem de status da ação efetuada (Serviço)
      function mostraMensagemStatusServico(mensagem, erro = false) {
        if (erro) {
          $('#mensagem-status-servico').append(`<div class="mensagem-status alert alert-danger alert-dismissible alert-resizing">
                                                <i class="icon fa fa-ban"></i> ${mensagem}
                                              </div>`);
          return;
        }
        $('#mensagem-status-servico').append(`<div class="mensagem-status alert alert-success alert-dismissible alert-resizing">
                                                <i class="icon fa fa-check"></i> ${mensagem}
                                              </div>`);
        return;
      }

      // Requisição de exclusão de Serviço
      function excluirServico(id) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        let url = '{{ route('servico.excluir', [':campanha_id', ':servico_id']) }}';
        url = url.replace(':campanha_id', $('#campanha_id').val()).replace(':servico_id', id);

        $.ajax({
          url: url,
          type: 'delete',
          dataType: 'json',
          success: function(data) {
            if (data.success) {
              loadDataTableServicos(true);
              mostraMensagemStatusServico(data.success);
              $('#modal-exclusao-servico').modal('hide');
            }
          },
          error: function(data) {
            if (data.responseJSON.error) {
              loadDataTableServicos(true);
              mostraMensagemStatusServico(data.responseJSON.error, true);
              $('#modal-exclusao-servico').modal('hide');
            }
          }
        });
      }

      /**
       *
       * PEDIDO DE DOAÇÃO
       *
       */
      // Ação botão editar pedido
      $('#pedidos').on('click', '.button-editar-pedido', function() {
        loadModalPedidoSelecionado($(this).data('id'));
      });

      // Ação botão excluir pedido
      $('#pedidos').on('click', '.button-excluir-pedido', function() {
        $('#id-pedido-exclusao').val($(this).data('id'));
        $('#titulo-pedido-exclusao').text(
          `Deseja confirmar a exclusão do pedido de doação "${$(this).data('titulo')}"?`);
      });

      // Ação botão confirmar da modal de exclusão de pedido
      $('#confirmar-pedido-exclusao').on('click', function() {
        excluirPedido($('#id-pedido-exclusao').val());
      });

      // Evento fechar modal de exclusão de pedido
      $('#modal-exclusao-pedido').on('hidden.bs.modal', function() {
        $('#id-pedido-exclusao').val('');
        $('#titulo-pedido-exclusao').text('');
      });

      // Evento abrir modal de cadastro de pedido
      $('#modal-cadastro-pedido').on('shown.bs.modal', function() {
        $('#modal-cadastro-servico #titulo').focus();
      });

      // Evento fechar modal de cadastro de pedido
      $('#modal-cadastro-pedido').on('hidden.bs.modal', function() {
        limpaCamposFormularioPedido();
        $('#modal-cadastro-pedido .modal-title').text('Cadastrar Pedido de Doação');
        limparErrosFormularioPedido();
      });

      // Envia o formulário de pedido cadastro/alteração
      $('#form-cadastro-pedido').on('submit', function(e) {
        e.preventDefault();

        limparErrosFormularioPedido();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        let id = $('#pedido_doacao_id').val();
        let url = '{{ route('pedido-doacao.cadastrar', $campanha->id) }}';
        let type = 'post';
        if (id !== '') {
          url = '{{ route('pedido-doacao.alterar', [':campanha_id', ':pedido_doacao_id']) }}';
          url = url.replace(':campanha_id', $('#campanha_id').val()).replace(':pedido_doacao_id', id);
          type = 'put';
        }

        $.ajax({
          url: url,
          data: $(this).serialize(),
          type: type,
          dataType: 'json',
          success: function(data) {
            if (data.success) {
              loadDataTablePedidos(true);
              mostraMensagemStatusPedido(data.success);
              $('#modal-cadastro-pedido').modal('hide');
            }
          },
          error: function(data) {
            if (data.responseJSON.errors) {
              $.each(data.responseJSON.errors, function(key, value) {
                $('#modal-cadastro-pedido #erro-' + key).text(value);
                $('#modal-cadastro-pedido .form-group-' + key).addClass('has-error');
              });
            }

            if (data.responseJSON.error) {
              loadDataTablePedidos(true);
              mostraMensagemStatusPedido(data.responseJSON.error, true);
              $('#modal-cadastro-pedido').modal('hide');
            }
          }
        });
      });

      // Limpa os campos do formulário de pedido
      function limpaCamposFormularioPedido() {
        $('#form-cadastro-pedido')[0].reset();
        $('#pedido_doacao_id').val('');
        $('#modal-cadastro-pedido #aceita-doacao-parcial-s').iCheck('check');
        $('#modal-cadastro-pedido #aceita-doacao-parcial-s').iCheck('update');
        $('#modal-cadastro-pedido #aceita-doacao-parcial-n').iCheck('uncheck');
        $('#modal-cadastro-pedido #aceita-doacao-parcial-n').iCheck('update');
        $('#modal-cadastro-pedido .modal-title').text('Cadastrar Pedido de Doação');
      }

      // Limpa os erros do formulário de pedido
      function limparErrosFormularioPedido() {
        $('#modal-cadastro-pedido #erro-titulo').text('');
        $('#modal-cadastro-pedido .form-group-titulo').removeClass('has-error');
        $('#modal-cadastro-pedido #erro-descricao').text('');
        $('#modal-cadastro-pedido .form-group-descricao').removeClass('has-error');
        $('#modal-cadastro-pedido #erro-valor').text('');
        $('#modal-cadastro-pedido .form-group-valor').removeClass('has-error');
      }

      // Busca os dados para a tabela de pedidos
      function loadDataTablePedidos(reload = false) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          url: '{{ route('pedido-doacao.index', $campanha->id) }}',
          type: 'get',
          dataType: 'json',
          success: function(data) {
            if (data.pedidos) {
              renderDataTablePedidos(data.pedidos, reload);
            }
          }
        });
      }

      // Atualiza a tabela de pedidos
      function renderDataTablePedidos(pedidos, reload) {
        let data = pedidos.map(function(pedido) {
          return {
            'titulo': pedido.titulo,
            'valor': pedido.valor.toLocaleString("pt-BR", {
              style: "currency",
              currency: "BRL"
            }),
            'acoes': `<div class="btn-group">
                        <button type="button" class="btn btn-default btn-flat button-editar-pedido" data-id="${pedido.id}"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-default btn-flat button-excluir-pedido" data-id="${pedido.id}" data-titulo="${pedido.titulo}"
                            data-toggle="modal" data-target="#modal-exclusao-pedido" data-backdrop="static" data-keyboard="false"><i class="fa fa-trash"></i></button>
                      </div>`,
          }
        });

        // primera vez
        if (!reload) {
          $('#pedidos').DataTable({
            data: data,
            columns: [{
                title: 'Título',
                data: 'titulo'
              },
              {
                title: 'Valor (R$)',
                data: 'valor'
              },
              {
                title: 'Ações',
                data: 'acoes'
              },
            ],
            ordering: false,
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
            pageLength: 10
          });
          return;
        }

        $('#pedidos').DataTable().clear().rows.add(data).draw();
      }

      // Busca os dados do pedido selecionado para alteração
      function loadModalPedidoSelecionado(id) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        let url = '{{ route('pedido-doacao.editar', [':campanha_id', ':pedido_doacao_id']) }}';
        url = url.replace(':campanha_id', $('#campanha_id').val()).replace(':pedido_doacao_id', id);

        $.ajax({
          url: url,
          type: 'get',
          dataType: 'json',
          success: function(data) {
            if (data.pedido) {
              renderModalPedido(data.pedido);
            }
          }
        });
      }

      // Atualiza o formulário de pedido para edição
      function renderModalPedido(pedido) {
        $('#modal-cadastro-pedido .modal-title').text('Editar Pedido de Doação');
        $('#modal-cadastro-pedido #pedido_doacao_id').val(pedido.id);
        $('#modal-cadastro-pedido #titulo').val(pedido.titulo);
        $('#modal-cadastro-pedido #descricao').val(pedido.descricao);
        $('#modal-cadastro-pedido #valor').val(pedido.valor);
        $('#modal-cadastro-pedido #aceita-doacao-parcial-s').iCheck('check');
        $('#modal-cadastro-pedido #aceita-doacao-parcial-s').iCheck('update');
        $('#modal-cadastro-pedido #aceita-doacao-parcial-n').iCheck('uncheck');
        $('#modal-cadastro-pedido #aceita-doacao-parcial-n').iCheck('update');
        if (!pedido.aceita_doacao_parcial) {
          $('#modal-cadastro-pedido #aceita-doacao-parcial-s').iCheck('uncheck');
          $('#modal-cadastro-pedido #aceita-doacao-parcial-s').iCheck('update');
          $('#modal-cadastro-pedido #aceita-doacao-parcial-n').iCheck('check');
          $('#modal-cadastro-pedido #aceita-doacao-parcial-n').iCheck('update');
        }

        $('#modal-cadastro-pedido').modal('show');
      }

      // Mostra a mensagem de status da ação efetuada (Pedido)
      function mostraMensagemStatusPedido(mensagem, erro = false) {
        if (erro) {
          $('#mensagem-status-pedido').append(`<div class="mensagem-status alert alert-danger alert-dismissible alert-resizing">
                                                <i class="icon fa fa-ban"></i> ${mensagem}
                                              </div>`);
          return;
        }
        $('#mensagem-status-pedido').append(`<div class="mensagem-status alert alert-success alert-dismissible alert-resizing">
                                                <i class="icon fa fa-check"></i> ${mensagem}
                                              </div>`);
        return;
      }

      // Requisição de exclusão de pedido
      function excluirPedido(id) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        let url = '{{ route('pedido-doacao.excluir', [':campanha_id', ':pedido_doacao_id']) }}';
        url = url.replace(':campanha_id', $('#campanha_id').val()).replace(':pedido_doacao_id', id);

        $.ajax({
          url: url,
          type: 'delete',
          dataType: 'json',
          success: function(data) {
            if (data.success) {
              loadDataTablePedidos(true);
              mostraMensagemStatusPedido(data.success);
              $('#modal-exclusao-pedido').modal('hide');
            }
          },
          error: function(data) {
            if (data.responseJSON.error) {
              loadDataTablePedidos(true);
              mostraMensagemStatusPedido(data.responseJSON.error, true);
              $('#modal-exclusao-pedido').modal('hide');
            }
          }
        });
      }
    });
  </script>
@endsection
