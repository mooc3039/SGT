@extends('layouts.master')
@section('content')

<!-- <div class="container"> -->
  <div class="row">
    <div class="col-md-12">

      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-5 border">
              <div class="panel panel-default">

                <div class="panel-body">
                  @include('layouts.empresa.dados_empresa')
                </div>
              </div>



            </div>

            <div class="col-md-4">

              <div class="panel panel-default">
                <div class="panel-body text-center">
                  <h2> <b> Dados do Cliente </b></h2> <hr>
                  Nome do Cliente: {{$venda->cliente->nome}}<br>
                  Endereço: {{$venda->cliente->endereco}}<br>
                  Nuit: {{$venda->cliente->nuit}}<br>
                </div>
              </div>
            </div>

            <div class="col-md-3">

              <div class="panel panel-default">
                <div class="panel-body text-center">
                  <h2> <b> Numero da Venda / Factura </b> </h2> <hr>
                  <h1>{{$venda->codigo}}</h1>
                </div>
              </div>


            </div>
          </div>
          <div class="row">
            <div class="col-md-6"> MAPUTO</div>
            <div class="col-md-6 text-right"> Data: {{date('d-m-Y', strtotime($venda->created_at))}} </div>
          </div>
        </div>


        <div class="panel-body">

          <div class="row">
            <div class="col-md-12">
              <div class="row" >
                <div class="col-md-8" style="margin-bottom: 10px">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalInserirItem" data-new_valor_total={{ $venda->valor_total }} data-new_venda_id={{ $venda->id }} data-new_aplicacao_motivo_iva={{ $venda->aplicacao_motivo_iva }}><i class="fa fa-plus"></i></button>
                </div>
                <div class="col-md-4">
                  <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
                </div>
              </div>
              <table class="table table-striped table-advance table-hover" id="tbl_create_edit_itens_vendas" data-order='[[ 0, "desc" ]]'>
                <thead>
                  <tr>
                    <th> Designação </th>
                    <th> Quantidade</th>
                    <th> Preço Unitário (Mtn)</th>
                    <th> Valor Total (Mtn) </th>
                    <th class="text-center"><i class="icon_close_alt2"></i> Remover </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($venda->itensVenda as $iten_venda)
                  <tr>
                    <td> {{$iten_venda->produto->descricao}} </td>

                    <td class="text-center"> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProdutoIten" data-venda_id={{ $venda->id }} data-produto_id={{ $iten_venda->produto->id }} data-descricao={{ $iten_venda->produto->descricao }} data-quantidade={{ $iten_venda->quantidade }} data-qtd_dispo={{ $iten_venda->produto->quantidade_dispo }} data-qtd_min={{ $iten_venda->produto->quantidade_min }} data-preco_venda={{ $iten_venda->produto->preco_venda }} data-valor={{$iten_venda->valor }} data-desconto={{ $iten_venda->desconto }} data-subtotal={{ $iten_venda->subtotal }} data-valor_total={{ $venda->valor_total }} data-aplicacao_motivo_iva={{ $venda->aplicacao_motivo_iva }} data-user_id={{ Auth::user()->id }}> {{$iten_venda->quantidade}} </button> </td>

                    <td> {{number_format($iten_venda->produto->preco_venda, 2, '.', ',')}}</td>
                    <td> {{number_format($iten_venda->valor, 2, '.', ',')}} </td>
                    {{ Form::open(['route'=>['iten_venda.destroy', $iten_venda->id], 'method'=>'DELETE']) }}
                    <td class="text-center">
                      {{ Form::button('<i class="icon_close_alt2"></i>', ['class'=>'btn btn-danger btn-sm submit_iten', 'type'=>'submit'] )}}
                    </td>
                    {{ Form::close() }}

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="panel-footer">
          <div class="row">

            <div class="col-md-6 border">


              <div class="panel panel-default">
                <div class="panel-heading">
                  Motivo Justificativo da não aplicação de imposto 
                  @if($venda->aplicacao_motivo_iva == 1)
                  <button type="button" class="btn btn-primary btn-xs" onclick="javascript:hideEditarMotivoNaoAplicacaoIva();">
                    <span><i class="fa fa-pencil"></i></span> 
                  </button>
                  @else
                  <button type="button" class="btn btn-primary btn-xs" onclick="javascript:hideNovoMotivoNaoAplicacaoIva();">
                    <span><i class="fa fa-plus"></i></span> 
                  </button>
                  @endif
                </div>
                <div class="panel-body" id="painel_motivo">
                  @if($venda->motivo_iva_id == null)
                  {{""}}
                  @else
                  {{$venda->motivoIva->motivo_nao_aplicacao}}
                  @endif
                </div>
                
                <div class="panel-body" id="painel_editar_motivo" style="display: none">
                  {{Form::model($venda, ['route'=>['venda.update', $venda->id], 'method'=>'PUT'])}}
                  <div class="row" id="hide_select_editar_motivo">
                    <div class="col-sm-12">
                      {{Form::label('motivo_iva_id', 'Selecione Motivo Justificativo da não aplicação de imposto')}}
                      <div class="input-group">
                        {{Form::select('motivo_iva_id', $motivos_iva, null, ['class'=>'form-control', 'id'=>'motivo_iva_id'] )}}

                        {{Form::text('aplicacao_motivo_iva', null, ['hidden', 'id'=>'aplicacao_motivo_iva'])}}

                        {{Form::text('old_motivo_iva_id', $venda->motivo_iva_id, ['hidden', 'id'=>'old_motivo_iva_id', 'disabled'])}}

                        
                        {{Form::text('old_aplicacao_motivo_iva', $venda->aplicacao_motivo_iva, ['hidden', 'id'=>'old_aplicacao_motivo_iva', 'disabled'])}}
                        
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="checkbox">
                        <label>
                          <h5><b> <input name="checkbox_motivo_imposto" id="checkbox_motivo_imposto" type="checkbox" onclick="javascript:anularMotivoDaNaoAPlicacaoDoImposto();"> Anular Motivo Justificativo da não aplicação de imposto</b></h5>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="btn-group btn-group-xm">
                        {{ Form::button('Salvar', ['type'=>'submit', 'class'=>'btn btn-xs btn-primary submit_iten']) }}

                        {{ Form::reset('Limpar', ['class'=>'btn btn-xs btn-default']) }}

                        <button type="button" class="btn btn-primary btn-xs" onclick="javascript:showMotivoIva();">
                          Cancelar 
                        </button>
                      </div>
                      
                    </div>
                  </div>
                  {{Form::close()}}
                </div>

                <div class="panel-body" id="painel_novo_motivo" style="display: none">
                  {{Form::open(['route'=>['venda.update', $venda->id], 'method'=>'PUT'])}}
                  <div class="row">
                    <div class="col-md-12">
                      {{Form::label('motivo_iva_id', 'Selecione Motivo Justificativo da não aplicação de imposto')}}
                      <div class="input-group">
                        {{Form::select('motivo_iva_id', $motivos_iva, null, ['class'=>'form-control'] )}}

                        {{Form::text('aplicacao_motivo_iva', 1, ['hidden'])}}
                        
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="btn-group btn-group-xm">
                        {{ Form::button('Salvar', ['type'=>'submit', 'class'=>'btn btn-xs btn-primary submit_iten']) }}

                        {{ Form::reset('Limpar', ['class'=>'btn btn-xs btn-default']) }}

                        <button type="button" class="btn btn-primary btn-xs" onclick="javascript:showMotivoIva();">
                          Cancelar 
                        </button>
                      </div>
                      
                    </div>
                  </div>
                  {{Form::close()}}
                </div>

              </div>

            </div>

            <div class="col-md-6 text-right">

              <table class="pull-right">
                @if($venda->aplicacao_motivo_iva == 1)
                <tr>
                  <td>Valor Total:</td>
                  <td style="width: 10px"></td>
                  <td>{{number_format($venda->valor_total, 2, '.', ',')}} Mtn</td>
                </tr>
                @else
                <tr>
                  <td>Sub-Total:</td>
                  <td style="width: 10px"></td>
                  <td>{{number_format($venda->valor_total, 2, '.', ',')}} Mtn</td>
                </tr>
                <tr>
                  <td>IVA(17%):</td>
                  <td></td>
                  <td>{{number_format($venda->iva, 2, '.', ',')}} Mtn</td>
                </tr>
                <tr>
                  <td>Valor Total:</td>
                  <td></td>
                  <td><b>{{number_format($venda->valor_iva, 2, '.', ',')}} Mtn</b></td>
                </tr>
                @endif
              </table>

            </div>

          </div>
          <br><br>
          <div class="row">

            <div class="col-md-6">

              <div class="panel panel-info">
                <div class="panel-heading">
                  Dados bancarios
                </div>
                <div class="panel-body">
                  @include('layouts.empresa.dados_bancarios_empresa')
                </div>
              </div>

            </div>

            <div class="col-md-6">



            </div>

          </div>
          <div class="row">
            <div class="col-md-6">
              <!-- <a href="" class="btn btn-primary">Imprimir Venda</a> -->

            </div>
            <div class="col-md-6 text-right"><a href="{{route('venda.index')}}" class="btn btn-warning">Voltar</a>

            </div>
          </div>
        </div>


      </div>



    </div>
  </div>
  <!-- </div> -->

  <!-- MODAL INSERIR ITEM -->
  @include('vendas.itens_venda.modals.frm_modal_inserir_iten_venda')
  <!-- FIM MODAL INSERIR ITEM -->

  <!-- MODAL EDITAR ITEM -->
  @include('vendas.itens_venda.modals.frm_modal_editar_iten_venda')
  <!-- FIM MODAL EDITAR ITEM -->

  <!-- MODAL EDITAR JUSTIFICATIVA -->
  <div class="modal fade" tabindex="-1" role="dialog" id="modalMotivoJustificativo">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><b>Motivo justificativo da não aplicação de imposto: </b>Editar<span id=""><span/></h4>
          </div>
          <div class="modal-body">

            {{Form::open(['route'=>'editar_motivo_venda', 'method'=>'POST', 'onsubmit'=>'submitFormMotivoJustificativo.disabled = true; return true;'])}}

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">

                  {{Form::textarea('motivo_justificativo_nao_iva', null, ['class' => 'form-control', 'id'=>'motivo_justificativo_nao_iva'])}}

                  {{Form::hidden('venda_id', null, ['class' => 'form-control', 'id'=>'venda_id'])}}
                </div>
              </div>
            </div>



            <div class="modal-footer">
              <div class="row">
                <div class="col-md-6 text-left">

                </div>
                <div class="col-md-6 text-right">
                  {{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
                  {{Form::submit('Salvar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormMotivoJustificativo'])}}
                </div>
              </div>



              {{Form::close()}}
            </div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- FIM MODAL EDITAR JUSTIFICATIVA -->

    {{Form::hidden('codigo_venda', $venda->id, ['id'=>'codigo_venda', 'disabled'])}}
    @endsection

    @section('script')
    <script>

    // DataTables Inicio
    $(document).ready(function() {

      var codigo_venda = $('#codigo_venda').val();
      var titulo = "Itens da Venda "+codigo_venda;   
      var msg_bottom = "Papelaria Agenda & Serviços";

      var oTable = $('#tbl_create_edit_itens_vendas').DataTable( {
        "processing": true,
        "pagingType": "full_numbers",
        "dom": 'Brtpl',
        buttons: [
            // 'print',
            // 'excelHtml5',
            // 'pdfHtml5'
            {
              text: 'Imprimir',
              extend: 'print',
              title: titulo,
              messageBottom: msg_bottom,
              className: 'btn btn-defaul btn-sm'
            },
            {
              text: 'Excel',
              extend: 'excelHtml5',
              title: titulo,
              messageBottom: msg_bottom,
              className: 'btn btn-defaul btn-sm'
            },
            {
              text: 'PDF',
              extend: 'pdfHtml5',
              title: titulo,
              messageBottom: msg_bottom,
              className: 'btn btn-defaul btn-sm'
            }
            ]
          });

      $('#pesq').keyup(function(){
        oTable.search($(this).val()).draw();
      });

    } );
  // DataTables Fim

  $(document).ready(function(){
    $('.submit_iten').on('click',function(){
      $(".wait").css("display", "block");
    });
  });

  $(document).ready(function(){
    $(document).ajaxStart(function(){
      $(".wait").css("display", "block");
      document.getElementById("new_quantidade").disabled = true;
    });
    $(document).ajaxComplete(function(){
      $(".wait").css("display", "none");
      document.getElementById("new_quantidade").disabled = false;
      $('#new_quantidade').focus(); // Nao esta no find price por tratar-se de modal aqui.
    });
  });


    //JAVASCRIPT MODAL NOVO ITEM

    $('#modalInserirItem').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var new_dta_valor_total = button.data('new_valor_total')
        var new_dta_venda_id = button.data('new_venda_id')
        var new_aplicacao_motivo_iva = button.data('new_aplicacao_motivo_iva')
        var modal = $(this)

        modal.find('.modal-body #new_venda_id').val(new_dta_venda_id);


        $('#modalInserirItem').delegate('#new_produto_id','change',function(){
          // Achar o preco e as quantidades do produto selecionado\

          var id = $('#new_produto_id').val();
          var dataId={'id':id};
          $.ajax({
            type  : 'GET',
            url   : '{!!URL::route('findPrice')!!}',
            dataType: 'json',
            data  : dataId,
            success:function(data){
              $('#new_preco_venda').val(Number.parseFloat(data.preco_venda).formatMoney());
              $('#new_quantidade_dispo').val(data.quantidade_dispo - data.quantidade_min);
              $('#new_qtd_dispo_referencial').val(data.quantidade_dispo - data.quantidade_min);
              newCalcularValores();

              if(new_aplicacao_motivo_iva == 1){
                hideIva();
              }
            },
            complete:function(data){
              $('#new_quantidade').focus();
            }
          });
        });


        $('#modalInserirItem').delegate('#new_quantidade,#new_preco_venda,#new_desconto','keyup',function(){

          numberOnly('#new_quantidade');
          numberOnly('#new_desconto');

          //calcular os valores de acordo com a qtd e o preco para o NovoItem antes e apos as validacoes feitas;
          newCalcularValores();  

          if(new_aplicacao_motivo_iva == 1){
            hideIva();
          }       

        });

        function newCalcularValores(){

          newValidarQuantidadeEspecificada();

          var new_quantidade = Number.parseInt(0);
          if( ($('#new_quantidade').val()) === "" || ($('#new_quantidade').val()) === null){
            new_quantidade = Number.parseInt(0);
          }else{
            new_quantidade = Number.parseInt($('#new_quantidade').val());
          }

          var new_preco_venda = Number.parseFloat(($('#new_preco_venda').val()).replace(/[^0-9-.]/g, ''));
          var new_desconto = Number.parseInt($('#new_desconto').val());
          var new_subtotal = Number.parseFloat((new_quantidade*new_preco_venda)-(new_quantidade*new_preco_venda*new_desconto)/100);
          var new_valor = Number.parseFloat(new_quantidade*new_preco_venda);

          var new_valor_total = Number.parseFloat(new_dta_valor_total);

          new_valor_total = new_valor_total + new_subtotal;

          var new_iva = Number.parseFloat(Number.parseFloat((new_valor_total*17)/100).toFixed(2));
          var new_valor_total_iva = (new_valor_total + new_iva);

          $('#new_subtotal').val(new_subtotal.formatMoney());
          $('#new_valor').val(new_valor.formatMoney());
          $('.new_valor_total_sem_iva').html(new_valor_total.formatMoney() + " Mtn");
          $('.new_iva').html(new_iva.formatMoney() + " Mtn");
          $('.new_valor_total_iva').html(new_valor_total_iva.formatMoney() + " Mtn");
          
        }

        function newValidarQuantidadeEspecificada(){

          var new_quantidade = Number.parseInt(0);
          if( ($('#new_quantidade').val()) === "" || ($('#new_quantidade').val()) === null){
            new_quantidade = Number.parseInt(0);
          }else{
            new_quantidade = Number.parseInt($('#new_quantidade').val());
          }

          var new_qtd_dispo_referencial = Number.parseInt($('#new_qtd_dispo_referencial').val());

              // Se a quantidade especificada for maior que a quantidade disponivel, mostra um alerta impedindo de avancar e reseta a quantidade escolhida para a quantidade zero
              if(new_quantidade > new_qtd_dispo_referencial){
                alert('A quantidade especificada excedeu o limite');
                $('#new_quantidade').val(0);

                var new_qtd_after_validation_fail = Number.parseInt($('#new_quantidade').val());
                var new_qtd_rest_after_validation_fail = new_qtd_dispo_referencial-new_qtd_after_validation_fail;

                $('#new_quantidade_dispo').val(new_qtd_rest_after_validation_fail);

              }else{

                $('#new_quantidade').val(new_quantidade);
                var new_quantidade_venda_rest = (new_qtd_dispo_referencial-new_quantidade);
                $('#new_quantidade_dispo').val(new_quantidade_venda_rest);
              }
            }

          });
      // JAVASCRIPT FIM MODAL NOVO ITEM

      // JAVASCRIPT MODAL EDITAR ITEM
      $('#modalProdutoIten').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var dta_venda_id = button.data('venda_id');
        var dta_produto_id = button.data('produto_id');
        var dta_descricao = button.data('descricao');
        var dta_quantidade = button.data('quantidade');
        var dta_qtd_dispo = button.data('qtd_dispo');
        var dta_qtd_min = button.data('qtd_min');
        var dta_quantidade_dispo = (dta_qtd_dispo - dta_qtd_min);
        var dta_preco_venda = button.data('preco_venda');
        var dta_valor = button.data('valor');
        var dta_desconto = button.data('desconto');
        var dta_subtotal = button.data('subtotal');
        var dta_valor_total = button.data('valor_total');
        var dta_aplicacao_motivo_iva = button.data('aplicacao_motivo_iva')
        var dta_user_id = button.data('user_id');
        var modal = $(this);

        modal.find('.modal-body #venda_id').val(dta_venda_id);
        modal.find('.modal-body #produto_id').val(dta_produto_id);
        modal.find('.modal-body #descricao').val(dta_descricao);
        modal.find('.modal-body #quantidade').val(dta_quantidade);
        modal.find('.modal-body #quantidade_dispo').val(dta_quantidade_dispo);
        modal.find('.modal-body #preco_venda').val(dta_preco_venda);
        modal.find('.modal-body #valor').val(dta_valor);
        modal.find('.modal-body #desconto').val(dta_desconto);
        modal.find('.modal-body #subtotal').val(dta_subtotal);
        // modal.find('.modal-body #valor_total').val(dta_valor_total);
        modal.find('.modal-body #user_id').val(dta_user_id);
        
        // Este input abaixo eh para efeitos de validacao da qtd no controller
        modal.find('.modal-body #qtd_dispo_referencial').val(Number.parseInt(dta_quantidade_dispo) + Number.parseInt(dta_quantidade));

        editCalcularValores();

        if(dta_aplicacao_motivo_iva == 1){
          hideIva();

        }


        $('#modalProdutoIten').delegate('#quantidade,#preco_venda,#desconto','keyup',function(){

          numberOnly('#quantidade');
          numberOnly('#desconto');
          
          editCalcularValores();

          if(dta_aplicacao_motivo_iva == 1){
            hideIva();

          }
          
        });

        function editCalcularValores(){

          editValidarQuantidadeEspecificada();

          var mdl_quantidade = Number.parseInt(0);
          if( ($('#quantidade').val()) === "" || ($('#quantidade').val()) === null){
            mdl_quantidade = Number.parseInt(0);
          }else{
            mdl_quantidade = Number.parseInt($('#quantidade').val());
          }

          var mdl_preco_venda = Number.parseFloat(($('#preco_venda').val()).replace(/[^0-9-.]/g, ''));
          var mdl_desconto = Number.parseInt($('#desconto').val());
          var mdl_subtotal = Number.parseFloat((mdl_quantidade*mdl_preco_venda)-(mdl_quantidade*mdl_preco_venda*mdl_desconto)/100);
          var mdl_valor = Number.parseFloat(mdl_quantidade*mdl_preco_venda);

          var mdl_valor_total = Number.parseFloat(dta_valor_total);
          var mdl_dta_subtotal = Number.parseFloat(dta_subtotal);

          var valor_incre_decre = Number.parseFloat(0);

          if(mdl_subtotal > mdl_dta_subtotal){

            valor_incre_decre = (mdl_subtotal - mdl_dta_subtotal);
            mdl_valor_total = (mdl_valor_total + valor_incre_decre);

          }else if(mdl_subtotal <= mdl_dta_subtotal){

            valor_incre_decre = (mdl_dta_subtotal - mdl_subtotal);
            mdl_valor_total = (mdl_valor_total - valor_incre_decre);

          }

          var iva = Number.parseFloat(Number.parseFloat((mdl_valor_total*17)/100).toFixed(2));
          var valor_total_iva = (mdl_valor_total + iva);

          $('#subtotal').val(mdl_subtotal);
          $('#valor').val(mdl_valor);
          $('.valor_total_sem_iva').html(mdl_valor_total.formatMoney() + " Mtn");
          $('.iva').html(iva.formatMoney() + " Mtn");
          $('.valor_total_iva').html(valor_total_iva.formatMoney() + " Mtn");
        };

        function editValidarQuantidadeEspecificada(){

          var mdl_quantidade = Number.parseInt(0);
          if( ($('#quantidade').val()) === "" || ($('#quantidade').val()) === null){
            mdl_quantidade = Number.parseInt(0);
          }else{
            mdl_quantidade = Number.parseInt($('#quantidade').val());
          }

          var mdl_qtd_dispo_referencial = (Number.parseInt(dta_quantidade_dispo) + Number.parseInt(dta_quantidade));

          
              // Se a quantidade especificada for maior que a quantidade disponivel, mostra um alerta impedindo de avancar e reseta a quantidade escolhida para a quantidade inicial a ser ditada.
              if(mdl_quantidade > mdl_qtd_dispo_referencial){
                alert('A quantidade especificada excedeu o limite.');
                $('#quantidade').val(dta_quantidade);

                var mdl_qtd_after_validation_fail = Number.parseInt($('#quantidade').val());

                $('#quantidade_dispo').val(mdl_qtd_dispo_referencial - mdl_qtd_after_validation_fail);

              }else{

                $('#quantidade').val(mdl_quantidade);
                $('#quantidade_dispo').val(mdl_qtd_dispo_referencial-mdl_quantidade);
              }
            };
          });


    // JAVASCRIPT FIM MODAL EDITAR ITEM

    $('#modalMotivoJustificativo').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget); // Button that triggered the modal
        var dta_venda_id = button.data('venda_id')
        var motivo_justificativo_nao_iva = $('#motivo_justificativo_nao_iva').val();

        var modal = $(this);

        modal.find('.modal-body #venda_id').val(dta_venda_id);
        modal.find('.modal-body #motivo_justificativo_nao_iva').val(motivo_justificativo_nao_iva);
        // console.log(dta_motivo_justificativo_nao_iva);
      });

    function hideIva(){

      var hide_iva = document.getElementsByClassName('hide_iva');
      var show_iva = document.getElementsByClassName('show_iva');

      for(i=0; i<hide_iva.length; i++){
        hide_iva[i].style.display = "none";
      }

      for(i=0; i<show_iva.length; i++){
        show_iva[i].style.display = "block";
      }

    }

    function hideEditarMotivoNaoAplicacaoIva(){

      var painel_motivo = document.getElementById('painel_motivo');
      var painel_editar_motivo = document.getElementById('painel_editar_motivo');

      painel_motivo.style.display = "none";
      painel_editar_motivo.style.display = "block";

    }

    function hideNovoMotivoNaoAplicacaoIva(){

      var painel_motivo = document.getElementById('painel_motivo');
      var painel_editar_motivo = document.getElementById('painel_editar_motivo');

      painel_motivo.style.display = "none";
      painel_novo_motivo.style.display = "block";

    }
    function showMotivoIva(){

      var painel_motivo = document.getElementById('painel_motivo');
      var painel_editar_motivo = document.getElementById('painel_editar_motivo');

      painel_motivo.style.display = "block";
      painel_editar_motivo.style.display = "none";
      painel_novo_motivo.style.display = "none";

    }

    function hideSelectMotivo(){
      var hide_select_editar_motivo = document.getElementById('hide_select_editar_motivo');
      hide_select_editar_motivo.style.display = "none";
    }
    function showSelectMotivo(){
      var hide_select_editar_motivo = document.getElementById('hide_select_editar_motivo');
      hide_select_editar_motivo.style.display = "block";
    }

    function anularMotivoDaNaoAPlicacaoDoImposto(){
      if (document.getElementById('checkbox_motivo_imposto').checked) {
        hideSelectMotivo();
        $('#aplicacao_motivo_iva').val(0);
        $('#motivo_iva_id').val("");
      }
      else {
        var old_aplicacao_motivo_iva = $('#old_aplicacao_motivo_iva').val();
        var old_motivo_iva_id = $('#old_motivo_iva_id').val();
        $('#aplicacao_motivo_iva').val(old_aplicacao_motivo_iva);
        $('#motivo_iva_id').val(old_motivo_iva_id);
        showSelectMotivo();
      }
    }


  </script>

  @endsection
