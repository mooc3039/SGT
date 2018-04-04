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
                  <h2> <b> Dados do Fornecedor </b></h2> <hr>
                  Nome do Fornecedor: {{$entrada->fornecedor->nome}}<br>
                  Endereço: {{$entrada->fornecedor->endereco}}<br>
                  Nuit: {{$entrada->fornecedor->nuit}}<br>
                </div>
              </div>
            </div>

            <div class="col-md-3">

              <div class="panel panel-default">
                <div class="panel-body text-center">
                  <h2> <b> Numero da Entrada / Factura </b> </h2> <hr>
                  <h1>{{$entrada->id}}</h1>
                </div>
              </div>


            </div>
          </div>
          <div class="row">
            <div class="col-md-6"> MAPUTO</div>
            <div class="col-md-6 text-right"> Data: {{$entrada->created_at}} </div>
          </div>
        </div>


        <div class="panel-body">

          <div class="row">
            <div class="col-md-12">
              <div class="row" >
                <div class="col-md-8" style="margin-bottom: 10px">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalInserirItem" data-new_valor_total={{ $entrada->valor_total }} data-new_entrada_id={{ $entrada->id }}><i class="fa fa-plus"></i></button>
                </div>
                <div class="col-md-4">
                  <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
                </div>
              </div>
              <table class="table table-striped table-advance table-hover" id="tbl_create_edit_itens_entradas" data-order='[[ 0, "desc" ]]'>
                <thead>
                  <tr>
                    <th><i class="icon_mobile"></i> Designação </th>
                    <th class="text-center"><i class="icon_profile"></i>Quantidade</th>
                    <th><i class="icon_mail_alt"></i> Preço Unitário </th>
                    <th><i class="icon_cogs"></i> Valor Total </th>
                    <th class="text-center"><i class="icon_close_alt2"></i> Remover </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($entrada->itensEntrada as $iten_entrada)
                  <tr>
                    <td> {{$iten_entrada->produto->descricao}} </td>

                    <td class="text-center"> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProdutoIten" data-entrada_id={{ $entrada->id }} data-produto_id={{ $iten_entrada->produto->id }} data-descricao={{ $iten_entrada->produto->descricao }} data-quantidade={{ $iten_entrada->quantidade }} data-qtd_dispo={{ $iten_entrada->produto->quantidade_dispo }} data-qtd_min={{ $iten_entrada->produto->quantidade_min }} data-preco_aquisicao={{ $iten_entrada->produto->preco_aquisicao }} data-valor={{$iten_entrada->valor }} data-desconto={{ $iten_entrada->desconto }} data-subtotal={{ $iten_entrada->subtotal }} data-valor_total={{ $entrada->valor_total }} data-user_id={{ Auth::user()->id }}> {{$iten_entrada->quantidade}} </button> </td>

                    <td> {{$iten_entrada->produto->preco_aquisicao}} </td>
                    <td> {{$iten_entrada->valor}} </td>
                    {{ Form::open(['route'=>['iten_entrada.destroy', $iten_entrada->id], 'method'=>'DELETE']) }}
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
                <div class="panel-body">
                  Motivo Justificativo da não aplicação de imposto:
                </div>
              </div>

            </div>

            <div class="col-md-6 text-right">

              <table class="pull-right">
               <tr>
                <td>Valor Total:</td>
                <td style="width: 10px"></td>
                <td><b>{{$entrada->valor_total}}</b></td>
              </tr>
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
            <!-- <a href="" class="btn btn-primary">Imprimir entrada</a> -->

          </div>
          <div class="col-md-6 text-right"><a href="{{route('entrada.index')}}" class="btn btn-warning">Voltar</a>

          </div>
        </div>
      </div>


    </div>



  </div>
</div>
<!-- </div> -->

<!-- MODAL INSERIR ITEM -->
@include('entradas.itens_entrada.modals.frm_modal_inserir_iten_entrada')
<!-- FIM MODAL INSERIR ITEM -->

<!-- MODAL EDITAR ITEM -->
@include('entradas.itens_entrada.modals.frm_modal_editar_iten_entrada')
<!-- FIM MODAL EDITAR ITEM -->

{{Form::hidden('codigo_entrada', $entrada->id, ['id'=>'codigo_entrada', 'disabled'])}}
@endsection

@section('script')
<script>

  // DataTables Inicio
  $(document).ready(function() {

    var codigo_entrada = $('#codigo_entrada').val();
    var titulo = "Itens da Entrada "+codigo_entrada;   
    var msg_bottom = "Papelaria Agenda & Serviços";

    var oTable = $('#tbl_create_edit_itens_entradas').DataTable( {
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
        var new_dta_entrada_id = button.data('new_entrada_id')
        var modal = $(this)

        modal.find('.modal-body #new_entrada_id').val(new_dta_entrada_id);


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
              $('#new_preco_aquisicao').val(data.preco_aquisicao);
              $('#new_quantidade_dispo').val(data.quantidade_dispo - data.quantidade_min);
              $('#new_qtd_dispo_referencial').val(data.quantidade_dispo - data.quantidade_min);
              newIncrementarQuantidadeDisponivel();
              newCalcularValores();
            },
            complete:function(data){
              $('#new_quantidade').focus();
            }
          });
        });

        $('#modalInserirItem').delegate('#new_quantidade','keyup',function(){
          // validar a qtd actual/especificada de acordo com os limites, qtd existente no stock
          newIncrementarQuantidadeDisponivel();

        });


        $('#modalInserirItem').delegate('#new_quantidade,#new_preco_aquisicao,#new_desconto','keyup',function(){

          numberOnly('#new_quantidade');
          numberOnly('#new_desconto');

          //calcular os valores de acordo com a qtd e o preco para o NovoItem antes e apos as validacoes acima feitas;
          newCalcularValores();         

        });

        function newIncrementarQuantidadeDisponivel(){

          var new_quantidade = $('#new_quantidade').val()*1; // E necessario para a adicao algebrica, ou o javascript vai entender como soma de duas strings
          var new_qtd_dispo_referencial = $('#new_qtd_dispo_referencial').val(); // E necessario para a adicao algebrica, ou o javascript vai entender como soma de duas strings

          new_qtd_dispo_referencial = (new_qtd_dispo_referencial*1);
          var new_quantidade_entrada_rest = (new_qtd_dispo_referencial+new_quantidade);
          $('#new_quantidade_dispo').val(new_quantidade_entrada_rest);
        }

        function newCalcularValores(){

          var new_quantidade = $('#new_quantidade').val();
          var new_preco_aquisicao = $('#new_preco_aquisicao').val();
          var new_desconto = $('#new_desconto').val();
          var new_subtotal = ((new_quantidade*new_preco_aquisicao)-(new_quantidade*new_preco_aquisicao*new_desconto)/100);
          var new_valor = (new_quantidade*new_preco_aquisicao);

          var new_valor_total = (new_dta_valor_total*1);

          new_valor_total = new_valor_total + new_subtotal;


          $('#new_subtotal').val(new_subtotal);
          $('#new_valor').val(new_valor);
          $('#new_valor_total').val(new_valor_total);
          $('#new_val_temp').html(new_valor_total.formatMoney(2,',','.')+ " Mtn");
        }

      });
      // JAVASCRIPT FIM MODAL NOVO ITEM

      // JAVASCRIPT MODAL EDITAR ITEM
      $('#modalProdutoIten').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var dta_entrada_id = button.data('entrada_id');
        var dta_produto_id = button.data('produto_id');
        var dta_descricao = button.data('descricao');
        var dta_quantidade = button.data('quantidade');
        var dta_qtd_dispo = button.data('qtd_dispo');
        var dta_qtd_min = button.data('qtd_min');
        var dta_quantidade_dispo = (dta_qtd_dispo - dta_qtd_min);
        var dta_preco_aquisicao = button.data('preco_aquisicao');
        var dta_valor = button.data('valor');
        var dta_desconto = button.data('desconto');
        var dta_subtotal = button.data('subtotal');
        var dta_valor_total = button.data('valor_total');
        var dta_user_id = button.data('user_id');
        var modal = $(this);

        modal.find('.modal-body #entrada_id').val(dta_entrada_id);
        modal.find('.modal-body #produto_id').val(dta_produto_id);
        modal.find('.modal-body #descricao').val(dta_descricao);
        modal.find('.modal-body #quantidade').val(dta_quantidade);
        modal.find('.modal-body #quantidade_dispo').val(dta_quantidade_dispo);
        modal.find('.modal-body #preco_aquisicao').val(dta_preco_aquisicao);
        modal.find('.modal-body #valor').val(dta_valor);
        modal.find('.modal-body #desconto').val(dta_desconto);
        modal.find('.modal-body #subtotal').val(dta_subtotal);
        modal.find('.modal-body #valor_total').val(dta_valor_total);
        modal.find('.modal-body #user_id').val(dta_user_id);
        
        // Este input abaixo eh para efeitos de validacao da qtd no controller
        modal.find('.modal-body #qtd_dispo_referencial').val(((dta_quantidade_dispo*1)));



        $('#modalProdutoIten').delegate('#quantidade','keyup',function(){
          // validar a qtd actual/especificada de acordo com os limites, qtd existente no stock
          editValidarQuantidadeEspecificada();

        });




        $('#modalProdutoIten').delegate('#quantidade,#preco_aquisicao,#desconto','keyup',function(){

          numberOnly('#quantidade');
          numberOnly('#desconto');
          
          editCalcularValores();
          
        });

        function editValidarQuantidadeEspecificada(){

          var quantidade = $('#quantidade').val()*1;
          var qtd_dispo_referencial = ((dta_quantidade_dispo*1)); 
          var quantidade_dispo = qtd_dispo_referencial+quantidade;

          if(quantidade_dispo < qtd_dispo_referencial*1){ // A dispon actual nao pode ser menor que a disponivel na DB, caso nao, faz o reset para os dados da DB
            alert('A Quantidade nao pode ser menor que a quantidade minima');
            $('#quantidade').val(dta_quantidade);
            $('#quantidade_dispo').val(dta_quantidade_dispo);
          }else{
              // Passou na validacao principal
            if(quantidade > dta_quantidade){ // Se a qtd actual for > q a qtd da DB aumenta-se
              var dif_incr = quantidade - dta_quantidade;
              $('#quantidade').val(quantidade);
              $('#quantidade_dispo').val(qtd_dispo_referencial + dif_incr);

            }else if(quantidade < dta_quantidade){ // Se a qtd actual for < q a qtd da DB diminui-se

              var dif_decr = dta_quantidade - quantidade;
              $('#quantidade').val(quantidade);
              $('#quantidade_dispo').val(qtd_dispo_referencial - dif_decr);

            }else{ // Se a qtd actual for == a qtd da DB manten-se
              $('#quantidade').val(quantidade);
              $('#quantidade_dispo').val(dta_quantidade_dispo);

            }
          }
        };

        function editCalcularValores(){

          var mdl_quantidade = $('#quantidade').val();
          var mdl_preco_aquisicao = $('#preco_aquisicao').val();
          var mdl_desconto = $('#desconto').val();
          var mdl_subtotal = ((mdl_quantidade*mdl_preco_aquisicao)-(mdl_quantidade*mdl_preco_aquisicao*mdl_desconto)/100);
          var mdl_valor = (mdl_quantidade*mdl_preco_aquisicao);

          var mdl_valor_total = (dta_valor_total*1);

          var valor_incre_decre = 0;

          if(mdl_subtotal > dta_subtotal){

            valor_incre_decre = (mdl_subtotal - dta_subtotal);
            mdl_valor_total = (mdl_valor_total + valor_incre_decre);

          }else if(mdl_subtotal <= dta_subtotal){

            valor_incre_decre = (dta_subtotal - mdl_subtotal);
            mdl_valor_total = (mdl_valor_total - valor_incre_decre);

          }

          $('#subtotal').val(mdl_subtotal);
          $('#valor').val(mdl_valor);
          $('#valor_total').val(mdl_valor_total);
          $('#val_temp').html(mdl_valor_total.formatMoney(2,',','.')+ " Mtn");
        };

      });


    // JAVASCRIPT FIM MODAL EDITAR ITEM

  </script>

  @endsection
