@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Entradas</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Entradas</li>
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
              <th><i class="icon_profile"></i> Código da Entrada </th>
              <th><i class="icon_mobile"></i> Data de Entrada </th>
              <th><i class="icon_mail_alt"></i> Valor Total </th>
              <th class="text-right"><i class="icon_cogs"></i> Operações </th>
            </tr>

            @foreach($entradas as $entrada)
            <tr>
              <td> {{$entrada->id}} </td>
              <td> {{$entrada->data}} </td>
              <td> {{$entrada->valor}} </td>
              <td class="text-right">
                <div class="btn-group">
                  <a class="btn btn-primary" href="{{route('entrada.show', $entrada->id)}}"><i class="fa fa-eye"></i></a>
                  <a class="btn btn-success" href="{{route('entrada.edit', $entrada->id)}}"><i class="fa fa-pencil"></i></a>

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
