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
      <header class="panel-heading">
        Saídas
      </header>
      <table class="table table-striped table-advance table-hover">
        <tbody>

          <tr>
            <th><i class="icon_profile"></i>Código da Saída </th>
            <th><i class="icon_mobile"></i> Data de Emissão </th>
            <th><i class="icon_mail_alt"></i> Cliente </th>
            <th><i class="icon_mail_alt"></i> Valor Total </th>
            <th class="text-right"><i class="icon_cogs"></i> Operações </th>
          </tr>

          @foreach($saidas as $saida)
          <tr>
            <td> {{$saida->id}} </td>
            <td> {{$saida->data}} </td>
            <td> {{$saida->cliente->nome}} </td>
            <td> {{$saida->valor_total}} </td>
            <td>
              <div class="btn-group pull-right">
                <a class="btn btn-primary" href="{{route('saida.show', $saida->id)}}"><i class="fa fa-eye"></i></a>
                <a class="btn btn-success" href="{{route('saida.edit', $saida->id)}}"><i class="fa fa-pencil"></i></a>
                
              </div>
            </td>
            
          </tr>
          @endforeach
        </tbody>
      </table>

    </section>
  </div>
</div>

@endsection
