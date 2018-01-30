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


      

      
      <div class="panel-body">
        
        <table class="table table-striped table-advance table-hover">
        <tbody>
          <tr>
            <th><i class="icon_profile"></i>Nome do Fornecedor</th>
            <th><i class="icon_mobile"></i> Endereço</th>
            <th><i class="icon_mail_alt"></i> Email</th>
            <th><i class="icon_pin_alt"></i> Telefone</th>
            <th><i class="icon_calendar"></i> Rubrica</th>
            <th><i class="fa fa-unlock-alt"></i> Activo </th>
            <th class="text-center"><i class="icon_cogs"></i> Operações</th>
          </tr>
          @if(count($fornecedores) > 0)
          @foreach($fornecedores as $fornecedor)
          <tr>
            <td> {{$fornecedor->nome}}</td>
            <td>{{$fornecedor->endereco}}</td>
            <td>{{$fornecedor->email}}</td>
            <td>{{$fornecedor->telefone}}</td>
            <td>{{$fornecedor->rubrica}}</td>
            <td>{{Form::checkbox('activo', $fornecedor->activo, $fornecedor->activo, ['class' => 'disabled'])}}</td>
            <td>
              <div class="btn-group pull-right">



                <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                <a class="btn btn-success" href="{{route('fornecedores.edit', $fornecedor->id)}}"><i class="fa fa-pencil"></i></a>

                @if($fornecedor->activo == true)
                <a class="btn btn-danger" href="{{route('fornecedores_desactivar', $fornecedor->id)}}"><i class="fa fa-lock"></i></a>
                @else
                <a class="btn btn-info" href="{{route('fornecedores_activar', $fornecedor->id)}}"><i class="fa fa-unlock"></i></a>
                @endif
               <!-- {!!Form::open(['route'=>['fornecedores.destroy', $fornecedor->fornecedor_id], 'method'=>'DELETE'])!!}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}} -->
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

      </div>
      


      <div class="panel-footer">

        <div class="row">
          <div class="col-md-6">

            <a href="{{route('fornecedores.create')}}">
              {{Form::label('fornecedor', 'Novo Fornecedor', ['class'=>'btn btn-primary'])}}
            </a>

          </div>
          <div class="col-md-6">

            @if($fornecedor->activo == true)

            <a href="{{route('fornecedores_inactivos')}}" class="btn btn-primary pull-right">
              Inactivos
            </a>

            @else

            <a href="{{route('fornecedores.index')}}" class="btn btn-primary pull-right">
              Activos
            </a>

            @endif

          </div>
        </div>


        
        

      </div>

    </section>
  </div>
</div>



@endsection
