@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Saídas</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Saídas</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <!-- <header class="panel-heading">
        Saídas
      </header> -->
      <div class="panel-body">
        <div class="row" style="margin-bottom: 10px">
          <div class="col-md-12">
            <a href="{{ route('saida.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-advance table-hover">
              <thead>
                <tr>
                  <th><i class="icon_profile"></i>Código da Saída </th>
                  <th><i class="icon_mobile"></i> Data de Emissão </th>
                  <th><i class="icon_mail_alt"></i> Cliente </th>
                  <th><i class="icon_mail_alt"></i> Valor Total </th>
                  <th class="text-right"><i class="icon_cogs"></i> Operações </th>
                </tr>
              </thead>
              <tbody>
                @foreach($saidas as $saida)
                <tr>
                  <td> {{$saida->id}} </td>
                  <td> {{$saida->data}} </td>
                  <td> {{$saida->cliente->nome}} </td>
                  <td> {{$saida->valor_total}} </td>
                  <td class="text-right">
                    {{ Form::open(['route'=>['saida.destroy', $saida->id], 'method'=>'DELETE']) }}
                    @php
                      $som_quantidade_rest = 0;
                    @endphp

                    @foreach($saida->itensSaida as $iten_saida)
                      @php
                        $som_quantidade_rest = $som_quantidade_rest + $iten_saida->quantidade_rest
                      @endphp
                    @endforeach

                    @if($som_quantidade_rest <= 0)
                      {{Form::button('Saída Fechada', ['class'=>'btn btn-warning btn-sm', 'style'=>'width:110px'])}}
                    @else
                      <a href="{{ route('create_guia', $saida->id)}}" class="btn btn-default btn-sm" style="width:110px">Guia de Entrega</a>
                    @endif
                    <div class="btn-group btn-group-sm">
                      <a class="btn btn-primary" href="{{route('saida.show', $saida->id)}}"><i class="fa fa-eye"></i></a>
                      <a class="btn btn-success" href="{{route('saida.edit', $saida->id)}}"><i class="fa fa-pencil"></i></a>
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
            {{ $saidas->links() }}
          </div>
        </div>
      </div>

    </section>
  </div>
</div>

@endsection
