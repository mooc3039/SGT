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

   <!--   {!! Form::open(['action' => 'FacturarController@index', 'method' => 'POST', 'class' => 'form-horizontal']) !!} -->
      {!!Form::open(['route'=>'insert','method'=>'POST', 'class' => 'form-horizontal'])!!}
        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
          <div class="form-group">
              
              <div class="col-sm-3">
                {{Form::label('nome', 'Nome do Cliente')}}
                 {{Form::select('nome', [''=>'Selecione Cliente',] + $cliente, null, ['class'=>'form-control'] )}}
              </div>
            </div>
          </div> 
         
          <div class="panel-footer">
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
                <th><i class="icon_mobile"></i> Total/Produto</th>
                <th><a class="btn btn-primary addRow" href="#"><i class="icon_plus_alt2"></i></a></th>
              </tr>
              <tr>
                <td>
                  <select class="form-control descricao" name="descricao[]">
                    <option value="0" selected="true" disabled="true">Selecione Produto</option>        
                    @foreach($produtos as $key => $p)
                     <option value="{!!$key!!}">{!!$p->descricao!!}</option>
                    @endforeach
                  </select>
                </td>
                <td><input type="text" name="quantidade[]" class="form-control quantidade"></td>
                <td><input type="text" name="preco_venda[]" class="form-control preco_venda"></td>
                <td><input type="text" name="desconto[]" class="form-control desconto"></td>
                <td><input type="text" name="subtotal[]" class="form-control subtotal"></td>
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
        {!! Form::close() !!}
    </section>
  </div>
</div>

@endsection
<script text="text/javascript">
 
    //função que adiciona a linha
    function addRow()
    {
      var tr='<tr>'+
          '<td>'+
            '<select class="form-control descricao" name="descricao[]">'+
              '<option value="0" selected="true" disabled="true">Selecione Producto</option>'+     
              '@foreach($produtos as $key => $p)'+
             ' <option value="{!!$key!!}">{!!$p->descricao!!}</option>'+
             '@endforeach'+
            '</select>'+
          '</td>'+
          '<td><input type="text" name="quantidade[]" class="form-control quantidade"></td>'+
          '<td><input type="text" name="preco_venda[]" class="form-control preco_venda"></td>'+
          '<td><input type="text" name="desconto[]" class="form-control desconto"></td>'+
          '<td><input type="text" name="subtotal[]" class="form-control subtotal"></td>'+
          '<td><a class="btn btn-danger remove" href="#"><i class="icon_close_alt2"></i></a></td>'+
       ' </tr>';
       $('tbody').append(tr);
    };
</script>