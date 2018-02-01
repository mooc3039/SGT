@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização do Cliente</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Clientes</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Clientes</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <!-- <header class="panel-heading">
        Parametrizar Cliente
      </header> -->
      
      <div class="panel-body">

        <table class="table table-striped table-advance table-hover">
          <tbody>

            <tr>
              <th><i class="icon_profile"></i>Nome do Cliente</th>
              <th><i class="icon_mobile"></i> Endereço</th>
              <th><i class="icon_mail_alt"></i> Telefone</th>
              <th><i class="icon_pin_alt"></i> Email</th>
              <th><i class="fa fa-id-card"></i> NUIT</th>
              <th><i class="fa fa-unlock-alt"></i> Activo</th>
              <th class="text-center"><i class="icon_cogs"></i> Operações</th>
            </tr>

            @foreach($clientes as $cliente)
            <tr>
              <td> {{$cliente->nome}} </td>
              <td> {{$cliente->endereco}} </td>
              <td> {{$cliente->telefone}} </td>
              <td> {{$cliente->email}}</td>
              <td> {{$cliente->nuit}}</td>
              <td>{{Form::checkbox('activo', $cliente->activo, $cliente->activo, ['class' => 'disabled'])}}
              <td class="text-right">
                <div class="btn-group">
                  <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                  <a class="btn btn-success" href="{{route('cliente.edit', $cliente->id)}}"><i class="fa fa-pencil"></i></a>
                  @if($cliente->activo == true)
                  <a href="{{route('clientes_desactivar', $cliente->id)}}" class="btn btn-danger"><i class="fa fa-lock"></i></a>
                  @else
                  <a href="{{route('clientes_activar', $cliente->id)}}" class="btn btn-info"><i class="fa fa-unlock"></i></a>
                  @endif

                </div>
              </td>

            </tr>
            @endforeach
          </tbody>
        </table>

      </div>

      <div class="panel-footer">
        <div class="row">
          <div class="col-md-6">

            <a href="{{route('cliente.create')}}" class="btn btn-primary">Adicionar Cliente</a>

          </div>
          <div class="col-md-6">

            @if($cliente->activo == true)

            <a href="{{route('clientes_inactivos')}}" class="btn btn-primary pull-right"> Inactivos </a>

            @else

            <a href="{{route('cliente.index')}}" class="btn btn-primary pull-right"> Activos </a>

            @endif
            
            
          </div>
        </div>
        
        
      </div>

    </section>
  </div>
</div>

@endsection
