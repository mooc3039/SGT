@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização do Tipo de Cotação</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Tipos de Cotação</li>
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
        <div class="row" style="margin-bottom: 10px">
          <div class="col-md-12">
            <a href="{{ route('tipo_cotacao.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-advance table-hover">

              <thead>
                <tr>
                  <th><i class="icon_profile"></i>Tipo de Cotação</th>
                  <th class="text-right"><i class="icon_cogs"></i> Operações</th>
                </tr>
              </thead>

              <tbody>

                @foreach($tipos_cotacao as $tipo_cotacao)
                <tr>
                  <td> {{$tipo_cotacao->nome}} </td>
                  <td class="text-right">
                    {{ Form::open(['route'=>['tipo_cotacao.destroy', $tipo_cotacao->id], 'method'=>'DELETE']) }}
                    <div class="btn-group btn-group-sm">
                      <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                      <a class="btn btn-success" href="{{ route('tipo_cotacao.edit', $tipo_cotacao->id) }}"><i class="fa fa-pencil"></i></a>

                      {{ Form::button('<i class="icon_close_alt2"></i>', ['type'=>'submit', 'class'=>'btn btn-danger']) }}


                    </div>
                    {{ Form::close() }}
                  </td>

                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>

      <div class="panel-footer">
        <div class="row">
          <div class="col-md-6">
            {{  $tipos_cotacao->links() }}

          </div>
        </div>


      </div>

    </section>
  </div>
</div>

@endsection