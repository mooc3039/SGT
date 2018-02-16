@extends('layouts.master')
@section('content')
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header"><i class="fa fa-file-text-o"></i>Cotações</h3>
      <ol class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="#">Home</a></li>
        <li><i class="icon_document_alt"></i>Cotação</li>
        <li><i class="fa fa-file-text-o"></i>Gerenciar Cotação</li>
      </ol>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <section class="panel panel-default">
        <header class="panel-heading">
          Gerenciamento das Cotações
        </header>


        {{ Form::open(['route'=>'cotacao.store', 'method'=>'POST', 'id'=>'form_cotacao']) }}

        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
          <div class="row" style="margin-bottom: 15px">
            <div class="form-horizontal">

              <div class="col-sm-4">
                {{Form::label('tipo_cotacao_id', 'Cotação')}}
                <div class="input-group">
                  {{Form::select('tipo_cotacao_id', [''=>'Tipo da Cotação',] + $tipos_cotacao, null, ['class'=>'form-control select_search'] )}}
                  {{Form::button('<i class="fa fa-plus"></i>', ['class'=>'input-group-addon', 'data-toggle'=>'modal', 'data-target'=>'#modalTipoCotacao', 'style'=>'width:auto; font-weight:lighter'])}}
                </div>
              </div>

              <div class="col-sm-4">
                {{Form::label('cliente_id', 'Cliente')}}
                <div class="input-group">
                  {{Form::select('cliente_id', [''=>'Cliente',] + $clientes, null, ['class'=>'form-control select_search'] )}}
                  {{Form::button('<i class="fa fa-plus"></i>', ['class'=>'input-group-addon', 'data-toggle'=>'modal', 'data-target'=>'#modalCliente', 'style'=>'width:auto; font-weight:lighter'])}}
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="panel-footer">
          {{Form::submit('Salvar Cotação', ['class'=>'btn btn-primary'])}}
        </div>


        <!-- começa a secção de cotacao na tabela-->

        <section class="panel">
          <header class="panel-heading">
            Produtos / Itens
          </header>

          <table class="table table-striped table-advance table-hover">
            <tbody>
              <tr>
                <th><i class="icon_profile"></i> Nome do Produto</th>
                <th><i class="icon_calendar"></i> Quantidade/Unidades</th>
                <th><i class="icon_mail_alt"></i> Preço</th>
                <th><i class="icon_pin_alt"></i> Desconto</th>
                <th><i class="icon_mobile"></i> Subtotal</th>
                <th><a class="btn btn-primary addRow" href="#"><i class="icon_plus_alt2"></i></a></th>
              </tr>
              <tr>
                <td>
                  <select class="form-control descricao" name="produto_id[]">
                    <option value="0" selected="true" disabled="true">Selecione Produto</option>
                    @foreach($produtos as $produto)
                      <option value="{!!$produto->id!!}">{!!$produto->descricao!!}</option>
                    @endforeach
                  </select>
                </td>
                <td><input type="text" name="quantidade[]" class="form-control quantidade"></td>
                <td><input type="text" name="preco_venda[]" class="form-control preco_venda"></td>
                <td><input type="text" name="desconto[]" class="form-control desconto" value="0"></td>
                <td><input type="text" name="subtotal[]" class="form-control subtotal" readyonly="true"></td>
                <td><a class="btn btn-danger remove" href="#"><i class="icon_close_alt2"></i></a></td>
              </tr>

            </tbody>
            <tfoot>
              <tr>
                <td style="border:none"></td>
                <td style="border:none"></td>
                <td style="border:none"></td>
                <td><b>Total</b></td>
                <td><b><div class="valor_visual" style="border:none"> </div></b></td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </section>
        {{ Form::hidden('valor_total', 0, ['class'=>'valor_total']) }}
        {{ Form::hidden('user_id', Auth::user()->id) }}
        {!!Form::hidden('_token',csrf_token())!!}
        {{ Form::close() }}
      </section>
    </div>
  </div>

  <!-- MODAL TIPO COTACAO -->
  <div class="modal fade" tabindex="-1" role="dialog" id="modalTipoCotacao">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Cadastrar Tipo de Cotação</h4>
        </div>
        <div class="modal-body">

          {{Form::open(['route'=>'tipo_cotacao_salvar_rback', 'method'=>'POST'])}}

          <div class="form-group">
            {{Form::label('nome', 'Nome', ['class'=>'control-lable'])}}
            {{Form::text('nome', null, ['placeholder' => 'Nome', 'class' => 'form-control'])}}
          </div>

          <div class="form-group">
            {{Form::label('descricao', 'Nome', ['class'=>'control-lable'])}}
            {{Form::textarea('descricao', null, ['placeholder' => 'Descric', 'class' => 'form-control'])}}
          </div>

        </div>
        <div class="modal-footer">

          {{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
          {{Form::submit('Salvar', ['class'=>'btn btn-primary'])}}

          {{Form::close()}}
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- FIM MODAL TIPO COTACAO -->

  <!-- MODAL CLIENTE -->
  <div class="modal fade" tabindex="-1" role="dialog" id="modalCliente">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Cadastrar Tipo de Cotação</h4>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-12">
              <div class="panel-body">
                {{ Form::open(['route'=>'cliente_salvar_rback', 'method'=>'POST']) }}
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-horizontal">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-4">
                          {{ Form::label('tipo_cliente_id', 'Tipo de Cliente', ['class'=>'control-label']) }}
                          {{ Form::select('tipo_cliente_id', [''=>'Tipo de Cliente',] + $tipos_cliente, null, ['class'=>'form-control', 'id'=>'mdl_cli_email']) }}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="radio-inline">
                            {{Form::radio('activo', '1')}} Activo
                          </div>
                          <div class="radio-inline">
                            {{Form::radio('activo', '0')}} Inactivo
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr style="border: 1px solid #ccc;">
                    <div class="form-horizontal">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-4">
                          {{ Form::label('nome', 'Nome', ['class'=>'control-label']) }}
                          {{ Form::text('nome', null, ['placeholder'=>'Nome','class'=>'form-control', 'id'=>'mdl_cli_nome']) }}
                        </div>
                        <div class="col-md-4">
                          {{ Form::label('endereco', 'Endereço', ['class'=>'control-label']) }}
                          {{ Form::text('endereco', null, ['placeholder'=>'Endereço','class'=>'form-control', 'id'=>'mdl_cli_endereco']) }}
                        </div>
                        <div class="col-md-4">
                          {{ Form::label('telefone', 'Telefone', ['class'=>'control-label']) }}
                          {{ Form::text('telefone', null, ['placeholder'=>'telefone','class'=>'form-control', 'id'=>'mdl_cli_telefone']) }}
                        </div>
                      </div>
                    </div>
                    <div class="form-horizontal">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-4">
                          {{ Form::label('email', 'Email', ['class'=>'control-label']) }}
                          {{ Form::text('email', null, ['placeholder'=>'Email','class'=>'form-control', 'id'=>'mdl_cli_email']) }}
                        </div>
                        <div class="col-md-4">
                          {{ Form::label('nuit', 'NUIT', ['class'=>'control-label']) }}
                          {{ Form::text('nuit', null, ['placeholder'=>'NUIT','class'=>'form-control', 'id'=>'mdl_cli_nuit']) }}
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>
              <div class="modal-footer">
                {{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
                {{Form::submit('Salvar', ['class'=>'btn btn-primary'])}}

                {{Form::close()}}
              </div>
            </div>
          </div>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- FIM MODAL CLIENTE -->

  @endsection
  @section('script')
    <script text="text/javascript">



    //função que adiciona a linha
    function addRow()
    {
      var tr='<tr>'+
      '<td>'+
      '<select class="form-control descricao" name="produto_id[]">'+
      '<option value="0" selected="true" disabled="true">Selecione Producto</option>'+
      '@foreach($produtos as $produto)'+
      ' <option value="{!!$produto->id!!}">{!!$produto->descricao!!}</option>'+
      '@endforeach'+
      '</select>'+
      '</td>'+
      '<td><input type="text" name="quantidade[]" class="form-control quantidade"></td>'+
      '<td><input type="text" name="preco_venda[]" class="form-control preco_venda"></td>'+
      '<td><input type="text" name="desconto[]" class="form-control desconto" value="0"></td>'+
      '<td><input type="text" name="subtotal[]" class="form-control subtotal" readyonly="true"></td>'+
      '<td><a class="btn btn-danger remove" href="#"><i class="icon_close_alt2"></i></a></td>'+
      ' </tr>';
      $('tbody').append(tr);

    };

    //==========adiciona mais uma linha da usando a função addRow==
    $('.addRow').on('click',function(){
      addRow();
    });

    //====remove a linha adicionada, foram corrigidos muitos bugs aqui===

    $('tbody').on('click','.remove',function(){
      var l=$('tbody tr').length;
      if (l==1) {
        alert('A Cotação deve conter pelo menos um item');
      }else{
        $(this).parent().parent().remove();
        total();
      }

    });
    //====trocar de focus para o proximo campo a preencher
    $('tbody').delegate('.descricao','change', function(){
      var tr = $(this).parent().parent();
      tr.find('.quantidade').focus();
    });


    //------devolver dados do price
    $('tbody').delegate('.descricao','change',function(){
      var tr= $(this).parent().parent();
      var id = tr.find('.descricao').val();
      var dataId={'id':id};
      $.ajax({
        type  : 'GET',
        url   : '{!!URL::route('findPrice')!!}',
        dataType: 'json',
        data  : dataId,
        success:function(data){
          tr.find('.preco_venda').val(data.preco_venda);
        }
      });
    });

    //======pegar os valores dos campos e calcular o valor de cada produto====
    $('tbody').delegate('.quantidade,.preco_venda,.desconto','keyup',function(){
      var tr = $(this).parent().parent();
      var quantidade = tr.find('.quantidade').val();
      var preco_venda = tr.find('.preco_venda').val();
      var desconto = tr.find('.desconto').val();
      var subtotal = (quantidade*preco_venda)-(quantidade*preco_venda*desconto)/100;
      tr.find('.subtotal').val(subtotal);
      total();
    });

    //==calculo do total de todas as linhas
    function total()
    {
      var total =0;
      $('.subtotal').each(function(i,e){
        var subtotal = $(this).val()-0;
        total +=subtotal;
      })
      $('.valor_visual').html(total.formatMoney(2,',','.')+ " Mtn");
      $('.valor_total').val(total);
    };


    // ==== formatando os numeros ====
    Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator){
      var n = this,
      decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
      decSeparator = decSeparator == undefined ? ".": decSeparator,
      thouSeparator = thouSeparator == undefined ? ",": thouSeparator,
      sign = n < 0 ? "-" : "",
      i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
      j = (j = i.length) > 3 ? j % 3 : 0;
      return sign + (j ? i.substr(0,j) + thouSeparator : "")
      + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator)
      + (decPlaces ? decSeparator + Math.abs(n-i).toFixed(decPlaces).slice(2) : "");
    };
    //---começam aqui as funçoes que filtram somente números
    //---find element by row--
    function findRowNum(input){
      $('tbody').delegate(input, 'keydown',function(){
        var tr =$(this).parent().parent();
        number(tr.find(input));
      });
    }

    function findRowNumOnly(input){
      $('tbody').delegate(input, 'keydown',function(){
        var tr =$(this).parent().parent();
        numberOnly(tr.find(input));
      });
    }

    //--numeros e pontos
    function number(input){
      $(input).keypress(function (evt){
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( key );
        var regex = /[-\d\.]/;
        var objRegex = /^-?\d*[\.]?\d*$/;
        var val = $(evt.target).val();
        if(!regex.test(key) || !objRegex.test(val+key) ||
        !theEvent.keyCode == 46 || !theEvent.keyCode == 8){
          theEvent.returnValue = false;
          if(theEvent.preventDefault) theEvent.preventDefault();
        };
      });
    };
    function findRowNumOnly(input){
      $('tbody').delegate(input, 'keydown',function(){
        var tr =$(this).parent().parent();
        numberOnly(tr.find(input));
      });
    }
    //-------------somente numeros
    function numberOnly(input){
      $(input).keypress(function(evt){
        var e = event || evt;
        var charCode = e.which || e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
      });
    }
    //---limitando somente para entrada de números
    findRowNum('.quantidade');
    findRowNum('.preco_venda');
    findRowNum('.desconto');


    //pegar dados e enviar para a rota que salva
    $('#form_cotacao').submit(function(e){
      e.preventDefault();
      data = $(this).serialize();

      $.ajax({
        type : "POST",
        url : "cotacao_store",
        dataType : "JSON",
        data : data,
        success : function(data){
          if(data.status == 'success'){
            window.location.href="index";
          }else{
            window.location.href="create"; // Necessario para actualizar as mensagens do flash(success ou error nas views ou routes)
          }
        },

        error : function(data){ // Automaticamente pega os erros de validacao do Form Request e devolve um json com uma mensagem padrao e o array contendo as validacoes que nao passaram no teste. Nao ha necessidade de fazer return response explicito no Controller

          // var errors = $.parseJSON(data.responseText);
          var errors = data.responseJSON;
          printErrorMsg(errors.errors);

        }


      });

      function printErrorMsg(msg){
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value){
          $(".print-error-msg").find("ul").append('<li><strong>Erro!!</strong> '+value+'</li>');
        });
      }

    });



    </script>
  @endsection
