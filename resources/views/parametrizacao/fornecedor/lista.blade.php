@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Fornecedor</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Fornecedor</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <header class="panel-heading">
        Lista dos Fornecedores
      </header>


      
    
      
      <table class="table table-striped table-advance table-hover">
        <tbody>
          <tr>
            <th><i class="icon_profile"></i>Nome do Fornecedor</th>
            <th><i class="icon_mobile"></i> Contacto</th>
            <th><i class="icon_mail_alt"></i> Email</th>
            <th><i class="icon_pin_alt"></i> Produto</th>
            <th><i class="icon_calendar"></i> Rubrica</th>
            <th><i class="icon_cogs"></i> Operações</th>
          </tr>
          @if(count($fornecedores) > 0)
          @foreach($fornecedores as $fornecedor)
          <tr>
            <td> {{$fornecedor->nome}}</td>
            <td>{{$fornecedor->contacto}}</td>
            <td>{{$fornecedor->email}}</td>
            <td>{{$fornecedor->produto}}</td>
            <td>{{$fornecedor->rubrica}}</td>
            <td>
              <div class="btn-group">
                <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                <a class="btn btn-success" href="{{route('fornecedores.edit', $fornecedor->fornecedor_id)}}"><i class="icon_check_alt2"></i></a>
                {!!Form::open(['route'=>['fornecedores.destroy', $fornecedor->fornecedor_id], 'method'=>'DELETE'])!!}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                {!!Form::close() !!}
                
              </div>
            </td>
          </tr>
          @endforeach
         
          @else
           <p>Não Existe nenhum Fornecedor Parametrizado</p>
          @endif
        </tbody>
      </table>
      
   
    
      <div class="panel-footer">
        <a href="{{route('fornecedores.create')}}">
          {{Form::label('fornecedor', 'Novo Fornecedor', ['class'=>'btn btn-primary'])}}
        </a>
     </div>
     
    </section>
    {{$fornecedores->links()}}
  </div>
</div>

  

@endsection
