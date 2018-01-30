@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Cotações</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Cotações</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <!-- <header class="panel-heading">
        Cotações
      </header> -->
      <div class="panel-body">

        <table class="table table-striped table-advance table-hover">
          <tbody>

            <tr>
              <th><i class="icon_profile"></i>Código da Cotação </th>
              <th><i class="icon_mobile"></i> Data de Emissão </th>
              <th><i class="icon_mail_alt"></i> Cliente </th>
              <th><i class="icon_mail_alt"></i> Valor Total </th>
              <th><i class="icon_cogs"></i> Operações </th>
            </tr>

            @foreach($cotacoes as $cotacao)
            <tr>
              <td> {{$cotacao->id}} </td>
              <td> {{$cotacao->data}} </td>
              <td> {{$cotacao->cliente->nome}} </td>
              <td> {{$cotacao->valor_total}} </td>
              <td>
                <div class="btn-group">
                  <a class="btn btn-primary" href="{{route('cotacao.show', $cotacao->id)}}"><i class="icon_plus_alt2"></i></a>
                  <a class="btn btn-success" href="{{route('cotacao.edit', $cotacao->id)}}"><i class="fa fa-pencil"></i></a>

                </div>
              </td>

            </tr>
            @endforeach
          </tbody>
        </table>

      </div>

    </section>
  </div>
</div>

@endsection
