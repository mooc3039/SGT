@extends('layouts.master')
@section('content')

<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Facturação</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Facturação</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Facturas</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <header class="panel-heading">
        Gerenciamento das Facturas
      </header>


     {!!Form::open(['action'=>'FacturacaoController@store','method'=>'POST','name'=>'data','id'=>'data', 'class' => 'form-horizontal'])!!}
   
        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
          <div class="form-group">
            
            <div class="col-sm-3">
              {{Form::label('tipo_cliente', 'Tipo de Cliente')}}
              <select class="form-control tipo_cliente" name="tipo_cliente" id="tipo_cliente">
                <option value="0" selected="true" disabled="true">selecione categoria</option>        
                @foreach($tipo_clientes as $tipo_cliente)
                 <option value="{{$tipo_cliente->id}}">{{$tipo_cliente->tipo_cliente}}</option>
                @endforeach
              </select>
            </div>  

              <div class="col-sm-3">
               {{Form::label('nome', 'Selecione Cliente')}}
               <div class="input-group">
                <select name="nome" class="form-control nome" id="nome" >
                    
                </select>
                <div class="input-group-addon">
                  <span class="fa fa-plus create-modal"></span>
                </div>
              </div>
           </div>
            </div>
          </div> 
         
          <div class="panel-footer">
            <a class="btn btn-info btnPrint" href="{{ route('prefactura')}}">Pré-Visual Factura</a>&nbsp;&nbsp;           
            {{Form::submit('Facturar cliente', ['class'=>'btn btn-primary'])}}
          </div>
        

        <!-- começa a secção de facturação na tabela-->
        
        <section class="panel">
          <header class="panel-heading">
            Producto a facturar
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
                  <select class="form-control descricao" name="descricao[]" id="descricao">
                    <option value="0" selected="true" disabled="true">Selecione Producto</option>  
                    @foreach($produtos as $key => $p)
                     <option value="{!!$key!!}">{!!$p->descricao!!}</option>
                    @endforeach
                  </select>
                </td>
                <td><input type="text" name="quantidade[]" class="form-control quantidade"></td>
                <td><input type="text" name="preco_venda[]" class="form-control preco_venda"></td>
                <td><input type="text" name="desconto[]" class="form-control desconto"></td>
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
                  <td><b class="total"></b></td>
                  <td></td>
                </tr>
              </tfoot>
          </table>
        </section>
        {!!Form::hidden('_token',csrf_token())!!}
        {!! Form::close() !!}
    </section>
  </div>
</div>


{{--  inicio da modal cliente  --}}
  <div id="create" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">

                    <div class="row">
                        <label class="control-label col-sm-3" for="nomecli">Nome cliente :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nomecli" name="nomecli" placeholder="Nome do cliente" required>
                            <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                    </div><br>

                    <div class="row">
                        <label class="control-label col-sm-3" for="endereco">Endereço :</label>
                        <div class="col-sm-9">
                              <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço" required>
                              <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                    </div><br>

                    <div class="row">
                        <label class="control-label col-sm-3" for="telefone">Telefone :</label>
                        <div class="col-sm-9">
                              <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone" required>
                              <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                    </div><br>

                    <div class="row">
                        <label class="control-label col-sm-3" for="nuit">Nuit :</label>
                        <div class="col-sm-9">
                              <input type="text" class="form-control" id="nuit" name="nuit" placeholder="Nuit" required>
                              <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                    </div><br>

                    <div class="row">
                        <label class="control-label col-sm-3" for="email">Email :</label>
                        <div class="col-sm-9">
                              <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                              <p class="error text-center alert alert-danger hidden"></p>
                        </div>
                    </div><br>

                    <div class="row">
                        <label class="control-label col-sm-3" for="tipo_cliente">Tipo de Cliente :</label>
                        <div class="col-sm-9">
                           /**    <input type="text" class="form-control" id="tipo_cliente" name="tipo_cliente" placeholder="Tipo de Cliente" required> */
                               <select class="form-control tipo_cliente" name="tipo_cliente" id="tipo_cliente">
                                <option value="0" selected="true" disabled="true">selecione categoria</option>        
                                @foreach($tipo_clientes as $key => $tipo_cliente)
                                 <option value="{{$key}}">{{$tipo_cliente->id}}</option>
                                @endforeach
                              </select>
                              <p class="error text-center alert alert-danger hidden"></p>  
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" type="submit" id="add">
                    <span class="glyphicon glyphicon-plus"></span>Inserir Cliente
                </button>
                <button class="btn btn-warning" type="button" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove"></span>Close
                </button>
            </div>
        </div>
    </div>
  </div>
  {{--  fim da modal cliente  --}}
@endsection
@section('script')
<script text="text/javascript">
  {{--modal view cliente --}}
  $(document).on('click','.create-modal', function(){
    $('#create').modal('show');
    $('.form-horizontal').show();
    $('.modal-title').text('Novo cliente');
});
 //function add(save)
    $("#add").click(function(){
      $.ajax({
          type : 'POST',
          url  : '/facturas/inicio/insert',
          data : {
              '_token': $('input[name=_token]').val(),
              'nomecli': $('input[name=nomecli]').val(),
              'endereco': $('input[name=endereco]').val(),
              'telefone': $('input[name=telefone]').val(),
              'nuit': $('input[name=nuit]').val(),
              'email': $('input[name=email]').val(),
              'tipo_cliente': $('#tipo_cliente option:selected').val(),
          },
          success: function(data){
              if((data.errors)){
                  $('.error').removeClass('hidden');
                  $('.error').text(data.errors.nomecli);
                  $('.error').text(data.errors.endereco);
                  $('.error').text(data.errors.telefone);
                  $('.error').text(data.errors.nuit);
                  $('.error').text(data.errors.email);
                  $('.error').text(data.errors.tipo_cliente);
              } else {
                  $('.error').remove();
                  $('#nome').append($("<option/>",{
                    value : data.id,
                    text  : data.nomecli,
                  }));
              }
          },
      });
      $('#nomecli').val('');
      $('#endereco').val('');
      $('#telefone').val('');
      $('#nuit').val('');
      $('#email').val('');
      $('#tipo_cliente').val('');
    });

  //trabalhando search dentro do select
   $("#nome").select2({
    placeholder: "Selecione cliente",
    allowClear: true
   });
   $("#descricao").select2({
    placeholder: "Selecione produto",
    allowClear: true
   });

  //trabalhando na dependencia
   $(document).ready(function(){
    
    $(document).on('change','.tipo_cliente',function(){
     // console.log("xa tchintxa");
      var cat_id = $(this).val();
     // console.log(cat_id);
    var div = $(this).parent().parent();
     var op="";
     $.ajax({
      type: 'get',
      url: '{!!URL::to('/facturas/depende')!!}',
      data:{'id':cat_id},
      success:function(data){
       // console.log('success');
       // console.log(data);
       op+='<option value="0" selected="selected" >Selecione Cliente</option>';
       for(var i=0;i<data.length;i++){
        op+='<option value="'+data[i].id+'">'+data[i].nome+'</option>';
       }
       div.find('.nome').html(" ");
       div.find('.nome').append(op);
      },
      error:function(){

      }
     });

    });
  });  

  
    //função que adiciona a linha
    function addRow()
    {
      var tr='<tr>'+
          '<td>'+
            '<select class="form-control descricao" name="descricao[]" id="descricao">'+
              '<option value="0" selected="true" disabled="true">Selecione Producto</option>'+     
              '@foreach($produtos as $key => $p)'+
             ' <option value="{!!$key!!}">{!!$p->descricao!!}</option>'+
             '@endforeach'+
            '</select>'+
          '</td>'+
          '<td><input type="text" name="quantidade[]" class="form-control quantidade"></td>'+
          '<td><input type="text" name="preco_venda[]" class="form-control preco_venda"></td>'+
          '<td><input type="text" name="desconto[]" class="form-control desconto"></td>'+
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
          alert('Não poderá remover o ultimo campo de facturação');
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
          $('.total').html(total.formatMoney(2,',','.')+ " Mtn");
          //tr.find('.total').val(total.formatMoney(2,',','.')+ " Mtn");
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
       $('form').submit(function(e){
        e.preventDefault();
        data = $(this).serialize();
        $.post('facturar',data,function(data){
            console.log(data);
        });
    });   



</script>
@endsection