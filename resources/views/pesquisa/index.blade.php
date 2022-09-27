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
      {{ __('Pesquisar') }}
      <small>Pesquisa por serviços e doações</small>
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
          <div class="box-header">
            <form id="form-pesquisa">
              <div class="row">
                <div class="col-sm-12 col-md-3">
                  <div class="form-group form-group-tipo has-feedback">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" id="tipo" class="form-control select2 tipo" style="width: 100%;">
                      <option value="S" selected>Serviço</option>
                      <option value="D" disabled>Doação</option>
                    </select>
                    <span class="help-block" role="alert" id="erro-tipo"></span>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3">
                  <div class="form-group form-group-descricao has-feedback">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control select2 estado" style="width: 100%;">
                      <option value="">Todos</option>
                      @foreach ($estados as $estado)
                        <option value="{{ $estado }}">{{ $estado }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group form-group-aberta-prestacoes-servico has-feedback">
                    <label for="cidade">Cidade</label>
                    <select name="cidade" id="cidade" class="form-control select2 cidade" style="width: 100%;"
                      disabled>
                      <option value="">Todas</option>
                    </select>
                    <span class="help-block" role="alert" id="erro-cidade"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <div class="form-group form-group-aberta-doacoes has-feedback">
                    <label for="titulo">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo"
                      placeholder="Digite um trecho do título para a pesquisa">
                    <span class="help-block" role="alert" id="erro-titulo"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <button type="submit" class="btn btn-primary pull-right">Pesquisar</button>
                </div>
              </div>
            </form>
          </div>
          <div class="box-body">
            <div id="mensagem-status-pesquisa">
              <!-- mensagem de status pesquisa -->
            </div>
            <table id="resultados" class="table-bordered table-striped table">

            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->

  <!-- Modal Visualização Serviço -->
  <div class="modal fade" id="modal-visualizacao-servico" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="form-aplicacao-servico">
          <div class="modal-header">
            <h4 class="modal-title">Aplicação</h4>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id-servico" name="servicos_id">
            <h4>Informações:</h4>
            <div id="descricao-servico-visualizacao"></div>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <div class="form-group form-group-data_inicio">
                  <label for="">Início</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker-inicio">
                    <input type="hidden" id="altFieldInicio" name="data_inicio">
                  </div>
                  <span class="help-block" role="alert" id="erro-data_inicio"></span>
                </div>
              </div>
              <div class="col-sm-12 col-md-6">
                <div class="form-group form-group-data_termino">
                  <label for="">Término</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker-termino">
                    <input type="hidden" id="altFieldTermino" name="data_termino">
                  </div>
                  <span class="help-block" role="alert" id="erro-data_termino"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="confirmar-aplicacao-servico" class="btn btn-success">Confirmar
              Aplicação</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /Modal Visualização Serviço -->
@endsection

@section('scripts')
  <!-- DataTables -->
  <script src="{{ asset('template/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('template/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <!-- Datepicker -->
  <script src="{{ asset('template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
  </script>
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
      setInterval(function() {
        $('.mensagem-status-pesquisa').remove();
      }, 10000);

      $('.select2').select2();

      $('#datepicker-inicio').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
      });
      $('#datepicker-termino').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
      });

      $('#datepicker-inicio').on('changeDate', function() {
        var data = $(this).val();
        data = data.split('/').reverse().join('-');
        $('#altFieldInicio').val(data);
      });

      $('#datepicker-termino').on('changeDate', function() {
        var data = $(this).val();
        data = data.split('/').reverse().join('-');
        $('#altFieldTermino').val(data);
      });

      $('#resultados').DataTable({
        data: [],
        columns: [{
            title: 'Informações',
            data: 'informacoes'
          },
          {
            title: 'ONG',
            data: 'ong'
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
        pageLength: 25
      });

      // Evento change dos Select2 de Estado
      $('#form-pesquisa .estado').change(function() {
        $('#form-pesquisa .select2.cidade').empty().trigger('change');
        $('#form-pesquisa .select2.cidade').select2({
          data: [{
            id: '',
            text: 'Todas'
          }]
        });
        $('#form-pesquisa .select2.cidade').prop('disabled', true);

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
                $('#form-pesquisa .select2.cidade').empty().trigger('change');
                $('#form-pesquisa .select2.cidade').select2({
                  data: [{
                    id: '',
                    text: 'Todas'
                  }]
                });
                $('#form-pesquisa .select2.cidade').select2({
                  data: data
                })
                $('#form-pesquisa .select2.cidade').prop('disabled', false);
              }
            }
          });
        }
      });

      // Envia o formulário de pesquisa
      $('#form-pesquisa').on('submit', function(e) {
        e.preventDefault();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        let url = '{{ route('pesquisa.pesquisar') }}';
        let type = 'post';

        $.ajax({
          url: url,
          data: $(this).serialize(),
          type: type,
          dataType: 'json',
          success: function(data) {
            if (data.resultados) {
              if (data.resultados.length > 0) {
                renderDataTableResultados(data.resultados);
              } else {
                renderDataTableResultados([]);
                mostraMensagemStatus('Nenhum registro encontrado!', true);
              }
            }
          },
        });
      });

      // Mostra a mensagem de status da ação efetuada
      function mostraMensagemStatus(mensagem, erro = false) {
        if (erro) {
          $('#mensagem-status-pesquisa').append(`<div class="mensagem-status alert alert-danger alert-dismissible alert-resizing">
                                                <i class="icon fa fa-ban"></i> ${mensagem}
                                              </div>`);
          return;
        }
        $('#mensagem-status-pesquisa').append(`<div class="mensagem-status alert alert-success alert-dismissible alert-resizing">
                                                <i class="icon fa fa-check"></i> ${mensagem}
                                              </div>`);
        return;
      }

      // Atualiza a tabela de resultados
      function renderDataTableResultados(resultados) {
        let data = resultados.map(function(resultado) {
          return {
            'informacoes': `<p><strong>Serviço: ${resultado.titulo}</strong><br>
                            ${resultado.descricao}<br>
                            Campanha: ${resultado.tituloCampanha}<br>
                            Endereço: ${resultado.endereco}<br>
                            Cidade: ${resultado.cidade}</p>`,
            'ong': resultado.ong,
            'acoes': `<button type="button" class="btn btn-primary btn-flat button-visualizar-servico" data-id="${resultado.id}" data-titulo="${resultado.titulo}"
                        data-descricao="${resultado.descricao}" data-endereco="${resultado.endereco}" data-titulo-campanha="${resultado.tituloCampanha}" data-cidade="${resultado.cidade}" data-ong="${resultado.ong}"
                        data-toggle="modal" data-target="#modal-visualizacao-servico" data-backdrop="static" data-keyboard="false">Me aplicar!</button>`,
          }
        });

        $('#resultados').DataTable().clear().rows.add(data).draw();
      }

      // Ação botão visualizar serviço
      $('#resultados').on('click', '.button-visualizar-servico', function() {
        $('#id-servico').val($(this).data('id'));
        $('#descricao-servico-visualizacao').html(`<p><strong>Serviço: ${$(this).data('titulo')}</strong><br>
                                                    ${$(this).data('descricao')}<br>
                                                    Campanha: ${$(this).data('titulo-campanha')}<br>
                                                    Endereço: ${$(this).data('endereco')}<br>
                                                    Cidade: ${$(this).data('cidade')}</p>`);
      });

      // Evento fechar modal de visualização de serviço
      $('#modal-visualizacao-servico').on('hidden.bs.modal', function() {
        $('#id-servico').val('');
        $('#descricao-servico-visualizacao').text('');
        $('#datepicker-inicio').val('');
        $('#datepicker-termino').val('');
        $('#altFieldInicio').val('');
        $('#altFieldTermino').val('');
        limparErrosFormularioAplicacaoServico();
      });

      // Envia o formulário de aplicação ao serviço
      $('#form-aplicacao-servico').on('submit', function(e) {
        e.preventDefault();

        limparErrosFormularioAplicacaoServico();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        let url = '{{ route('prestacao-servico.cadastrar') }}';
        let type = 'post';

        $.ajax({
          url: url,
          data: $(this).serialize(),
          type: type,
          dataType: 'json',
          success: function(data) {
            if (data.success) {
              mostraMensagemStatus(data.success);
              $('#modal-visualizacao-servico').modal('hide');
            }
          },
          error: function(data) {
            if (data.responseJSON.errors) {
              $.each(data.responseJSON.errors, function(key, value) {
                $('#modal-visualizacao-servico #erro-' + key).text(value);
                $('#modal-visualizacao-servico .form-group-' + key).addClass('has-error');
              });
            }

            if (data.responseJSON.error) {
              mostraMensagemStatus(data.responseJSON.error, true);
              $('#modal-visualizacao-servico').modal('hide');
            }
          }
        });
      });

      // Limpa os campos do formulário de aplicação ao serviço
      function limpaCamposFormularioAplicacaoServico() {
        $('#form-aplicacao-servico')[0].reset();
        $('#id-servico').val('');
      }

      // Limpa os erros do formulário de aplicação ao serviço
      function limparErrosFormularioAplicacaoServico() {
        $('#modal-visualizacao-servico #erro-data_inicio').text('');
        $('#modal-visualizacao-servico .form-group-data_inicio').removeClass('has-error');
        $('#modal-visualizacao-servico #erro-data_termino').text('');
        $('#modal-visualizacao-servico .form-group-data_termino').removeClass('has-error');
      }
    })
  </script>
@endsection
