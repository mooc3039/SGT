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


        <div class="panel-footer">

            <div class="row">
              <div class="col-md-6">
    
                <a href="{{route('factura.create')}}">
                  {{Form::label('factura', 'Nova Facturação', ['class'=>'btn btn-primary'])}}
                </a>
    
              </div>
              <div class="col-md-6">
    
              </div>
            </div>
    
          </div>

      
      <div class="panel-body">
        
        <table class="table table-striped table-advance table-hover">
        <tbody>
          <tr>
            <th><i class="icon_profile"></i>Produto</th>
            <th><i class="icon_mobile"></i> Quantidade</th>
            <th><i class="icon_mail_alt"></i> Preço Unitário</th>
            <th><i class="icon_pin_alt"></i> Desconto</th>
            <th><i class="icon_calendar"></i> Subtotal</th>
            <th class="text-center"><i class="icon_cogs"></i> Operações</th>
          </tr>
          @if(count($facturas) > 0)
          @foreach($facturas as $factura)
          <tr>
            <td> {{$factura->produto_id}}</td>
            <td>{{$factura->quantidade}}</td>
            <td>{{$factura->preco_venda}}</td>
            <td>{{$factura->desconto}}</td>
            <td>{{$factura->subtotal}}</td>
            <td>
              <div class="btn-group pull-right">



                <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                <a class="btn btn-success" href="{{route('factura.edit', $factura->id)}}"><i class="fa fa-pencil"></i></a>

               
                <a class="btn btn-danger" href=""><i class="fa fa-lock"></i></a>
                
                <a class="btn btn-info" href=""><i class="fa fa-unlock"></i></a>
               
              
                
              </div>
            </td>
            
          </tr>
          @endforeach
          @else
          <p>Não Existe nenhum Fornecedor Parametrizado</p>
          @endif
        </tbody>
      </table>

      </div>

    </section>
    {{$facturas->links()}}
  </div>
</div>



@endsection
