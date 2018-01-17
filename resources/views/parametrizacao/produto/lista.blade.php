@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Produto</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Produto</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <header class="panel-heading">
        Lista dos Produto
      </header>


      
    
      
      <table class="table table-striped table-advance table-hover">
        <tbody>
          <tr>
            <th><i class="icon_profile"></i>Nome do Produto</th>
            <th><i class="icon_mobile"></i> Categoria/Tipo</th>
            <th><i class="icon_mail_alt"></i> Preço</th>
            <th><i class="icon_pin_alt"></i> Fornecedor</th>
            <th><i class="icon_calendar"></i> Validade</th>
            <th><i class="icon_cogs"></i> Operações</th>
          </tr>
          @if(count($produtos) > 0)
          @foreach($produtos as $produto)
          <tr>
            <td> {{$produto->nome}}</td>
            <td>{{$produto->tipo}}</td>
            <td>{{$produto->preco}}</td>
            <td>{{$produto->fornecedor}}</td>
            <td>{{$produto->validade}}</td>
            <td>
              <div class="btn-group">
                <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                <a class="btn btn-success" href="{{route('produtos.edit', $produto->produto_id)}}"><i class="icon_check_alt2"></i></a>
                <a class="btn btn-danger" href="{{route('produtos.destroy', $produto->produto_id)}}"><i class="icon_close_alt2"></i></a>
              </div>
            </td>
          </tr>
          @endforeach
         
          @else
           <p>Não Existe nenhum Produto Parametrizado</p>
          @endif
        </tbody>
      </table>
      
   
    
      <div class="panel-footer">
        <a href="{{route('produtos.create')}}">
          {{Form::label('produto', 'Novo Produto', ['class'=>'btn btn-primary'])}}
        </a>
     </div>
     
    </section>
    {{$produtos->links()}}
  </div>
</div>

  

@endsection